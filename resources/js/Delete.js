class Delete {
    constructor() {
        this.element = document.querySelector('.delete.confirm');
    }

    register() {
        const message = this.element.getAttribute('data-confirm');
        this.element.addEventListener('click', (e) => Delete.confirm(e, message));
    }

    static confirm(e, message) {
        if (!confirm(message)) {
            e.preventDefault();
            e.stopPropagation();
        }
    }
}

export default Delete
