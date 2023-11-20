document.addEventListener('DOMContentLoaded', function() {
  const buttonMenu = document.getElementById('button-menu');
  const mainNav = document.querySelector('.main-nav');

  if (buttonMenu) {
    buttonMenu.addEventListener('click', function() {
      document.querySelector('header').classList.toggle('nav-open');
      document.body.classList.toggle('nav-open');
    });
  }

  // Evento clic en cualquier parte del documento
  document.addEventListener('click', function (event) {
    var nav = document.getElementById('nav');
    var overlay = document.getElementById('overlay');
    var buttonMenu = document.getElementById('button-menu');

    // Verificar si se hizo clic fuera del menú de hamburguesa y del botón de hamburguesa
    if (!nav.contains(event.target) && !buttonMenu.contains(event.target)) {
      nav.classList.remove('nav-open');
      overlay.classList.remove('nav-open');
      document.body.classList.remove('nav-open');
    }
  });

  // Evitar que el evento clic se propague desde el menú a los elementos subyacentes
  mainNav.addEventListener('click', function (event) {
    event.stopPropagation();
  });
});

  document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filtro-proyectos button');
    const proyectos = document.querySelectorAll('.proyecto');

    filterButtons.forEach(button => {
      button.addEventListener('click', function() {
        const category = this.dataset.category;

        proyectos.forEach(proyecto => {
          const proyectoCategory = proyecto.dataset.category;

          if (category === 'all' || category === proyectoCategory) {
            proyecto.style.display = 'block';
          } else {
            proyecto.style.display = 'none';
          }
        });
      });
    });
  });


