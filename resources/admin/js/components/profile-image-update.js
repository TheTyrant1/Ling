export default class ProfileImageUpdate {
    constructor(inputId, previewId) {
        this.input = document.getElementById(inputId);
        this.preview = document.getElementById(previewId);

        if (this.input && this.preview) {
            this.init();
        }
    }

    init() {
        this.input.addEventListener('change', (event) => {
            const file = event.target.files[0];

            if (file) {
                const tempUrl = URL.createObjectURL(file);
                this.preview.src = tempUrl;

                this.preview.onload = () => {
                    URL.revokeObjectURL(tempUrl);
                };
            }
        });
    }
}
