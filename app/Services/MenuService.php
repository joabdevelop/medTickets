<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Profissional;

class MenuService
{
    // Propriedade para armazenar o menu filtrado (memoização)
    protected ?array $cachedMenu = null;

    public function getFilteredMenuItems(): array
    {
        // 1. Verifica se já calculamos nesta requisição
        if ($this->cachedMenu !== null) {
            return $this->cachedMenu;
        }

        $userId = Auth::user()->id;

        $tipoAcesso = Profissional::where('user_id', $userId)->value('tipo_acesso');

        switch ($tipoAcesso) {
            case 'Cliente':
                $userProfileId = 1;
                break;

            case 'Estagiario':
                $userProfileId = 2;
                break;

            case 'Funcionario':
                $userProfileId = 3;
                break;

            case 'Gestor':
                $userProfileId = 4;
                break;

            case 'Admin':
                $userProfileId = 5;
                break;

            default:
                $userProfileId = 1;
                break;
        }

        $menuItems = collect(config('adminpanel.menu'));

        $filterMenu = function ($items) use (&$filterMenu, $userProfileId) {
            return $items
                ->map(function ($item) use (&$filterMenu, $userProfileId) {
                    $hasPermission = true;

                    if (isset($item['perfil'])) {
                        $hasPermission = in_array($userProfileId, $item['perfil']);
                    }

                    if (isset($item['submenu'])) {
                        $filteredSub = $filterMenu(collect($item['submenu']));

                        if ($filteredSub->isNotEmpty()) {
                            $item['submenu'] = $filteredSub->values()->all();
                            $hasPermission = true;
                        } else {
                            unset($item['submenu']);
                        }
                    }

                    return $hasPermission ? $item : null;
                })
                ->filter()
                ->values();
        };

        $filteredMenuItems = $filterMenu($menuItems);

        // 2. Armazena o resultado antes de retornar (Memoização)
        $this->cachedMenu = array_values($filteredMenuItems->toArray());

        return $this->cachedMenu;
    }
}
