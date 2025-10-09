

// Função para inicializar a TreeView
function initTreeView(treeId, options = {}) {
    const openedClass = options.openedClass || 'glyphicon-minus-sign';
    const closedClass = options.closedClass || 'glyphicon-plus-sign';

    const tree = document.getElementById(treeId);
    if (!tree) return;

    tree.classList.add('tree');

    const branches = tree.querySelectorAll('li');
    branches.forEach(branch => {
        const sublist = branch.querySelector('ul');
        if (sublist) {
            branch.classList.add('branch');

            const indicator = document.createElement('span');
            indicator.classList.add('indicator', closedClass);
            indicator.style.cursor = 'pointer';
            indicator.style.marginRight = '5px';

            branch.insertBefore(indicator, branch.firstChild);

            sublist.style.display = 'none';

            indicator.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = indicator.classList.contains(openedClass);
                indicator.classList.toggle(openedClass, !isOpen);
                indicator.classList.toggle(closedClass, isOpen);
                sublist.style.display = isOpen ? 'none' : 'block';
            });

            const clickable = branch.querySelector('a, button');
            if (clickable) {
                clickable.addEventListener('click', (e) => {
                    indicator.click();
                });
            }
        }
    });
}


  // Fechar dropdown ao clicar fora (Este já estava correto dentro de DOMContentLoaded)
    const userDropdownContainer = document.querySelector('.user-dropdown-container');
    const dropdown = document.querySelector('.user-dropdown-menu');
    if (userDropdownContainer && dropdown) {
        document.addEventListener('click', function (event) {
            // Se o clique não foi dentro do container do dropdown E o dropdown está ativo
            if (!userDropdownContainer.contains(event.target) && dropdown.classList.contains('active')) {
                dropdown.classList.remove('active');
            }
        });
    }


    // --- CÓDIGO PARA O DROPDOWN DO USUÁRIO ---
    const userInfoDiv = document.querySelector('.user-info');
    userInfoDiv.addEventListener('mouseenter', function () {
        userInfoDiv.classList.add('active');
        const dropdown = document.querySelector('.user-dropdown-menu');
        if (dropdown) dropdown.classList.add('active');
    });
    //const dropdown = document.querySelector('.user-dropdown-menu');

    dropdown.addEventListener('mouseleave', function () {
        dropdown.classList.remove('active');
        const userInfoDiv = document.querySelector('.user-info');
        if (userInfoDiv) userInfoDiv.classList.remove('active');
    });


    

   // Função para alternar o dropdown do usuário
    function toggleUserDropdown() {
        const dropdown = document.querySelector('.user-dropdown-menu');
        if (dropdown) { // Verificação para garantir que o elemento existe
            if (dropdown.classList.contains('active')) {
                dropdown.classList.remove('active');
            } else {
                dropdown.classList.add('active');
            }
        }
    }
    // === Listener para abrir/fechar o dropdown do usuário (CORREÇÃO AQUI!) ===
    //const userInfoDiv = document.querySelector('.user-info');
    if (userInfoDiv) {


        userInfoDiv.addEventListener('mouseenter', toggleUserDropdown); // Anexa o listener aqui
        userInfoDiv.addEventListener('mouseleave', toggleUserDropdown); // Anexa o listener aqui

    }