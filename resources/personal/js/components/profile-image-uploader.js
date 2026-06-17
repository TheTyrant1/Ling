export default class ProfileImageUploader {
    constructor(element) {
        // Перевіряємо, чи переданий елемент взагалі існує
        if (!element) return;
        this.container = element;

        // Шукаємо елементи всередині форми за класами
        this.input = this.container.querySelector('.avatar-input');
        this.preview = this.container.querySelector('.avatar-preview');
        this.saveBtn = this.container.querySelector('.avatar-save-btn');

        // Якщо базових елементів немає — тихо виходим, не ламаючи інший JS
        if (!this.input || !this.preview) return;

        this.init();
    }

    init() {
        this.input.addEventListener('change', (evt) => this.handleFileChange(evt));
    }

    handleFileChange(evt) {
        const [file] = evt.target.files;

        if (file) {
            // Створюємо тимчасове посилання на картинку в пам'яті браузера
            this.preview.src = URL.createObjectURL(file);

            // Показуємо кнопку збереження
            if (this.saveBtn) {
                this.saveBtn.classList.remove('d-none');
            }
        }
    }
}
