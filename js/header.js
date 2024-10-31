document.addEventListener('DOMContentLoaded', function () {
    var dropdowns = document.querySelectorAll('.nav-item.dropdown');

    dropdowns.forEach(function (dropdown) {
        dropdown.addEventListener('mouseover', function () {
            var dropdownMenu = this.querySelector('.dropdown-menu');
            dropdownMenu.classList.add('show');
        });

        dropdown.addEventListener('mouseout', function () {
            var dropdownMenu = this.querySelector('.dropdown-menu');
            dropdownMenu.classList.remove('show');
        });
    });
});