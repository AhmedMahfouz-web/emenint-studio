// Simple Modal Handler
const Modal = {
    init() {
        // Create modal HTML
        const modalHtml = `
            <div id="clientModal" class="my-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>إضافة عميل جديد</h3>
                        <span class="close-btn">&times;</span>
                    </div>
                    <form id="clientForm">
                        <div class="modal-body">
                            <div class="input-group">
                                <label>اسم العميل *</label>
                                <input type="text" name="name" required>
                            </div>
                            <div class="input-group">
                                <label>البريد الإلكتروني</label>
                                <input type="email" name="email">
                            </div>
                            <div class="input-group">
                                <label>رقم الهاتف</label>
                                <input type="text" name="phone">
                            </div>
                            <div class="input-group">
                                <label>الشركة</label>
                                <input type="text" name="company">
                            </div>
                            <div class="input-group">
                                <label>العنوان</label>
                                <textarea name="address"></textarea>
                            </div>
                            <div class="input-group">
                                <label>الدولة</label>
                                <input type="text" name="country">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="cancel-btn">إلغاء</button>
                            <button type="submit" class="save-btn">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        `;

        // Add modal to page
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Add styles
        const styles = document.createElement('style');
        styles.textContent = `
            .my-modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
            }

            .modal-content {
                background: white;
                width: 90%;
                max-width: 500px;
                margin: 50px auto;
                border-radius: 8px;
                position: relative;
            }

            .modal-header {
                padding: 15px;
                border-bottom: 1px solid #ddd;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .close-btn {
                cursor: pointer;
                font-size: 24px;
            }

            .modal-body {
                padding: 15px;
                max-height: 70vh;
                overflow-y: auto;
            }

            .input-group {
                margin-bottom: 15px;
            }

            .input-group label {
                display: block;
                margin-bottom: 5px;
            }

            .input-group input,
            .input-group textarea {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            .modal-footer {
                padding: 15px;
                border-top: 1px solid #ddd;
                text-align: right;
            }

            .save-btn, .cancel-btn {
                padding: 8px 16px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-left: 10px;
            }

            .save-btn {
                background: #4CAF50;
                color: white;
            }

            .cancel-btn {
                background: #f44336;
                color: white;
            }

            .show-modal {
                display: block;
            }
        `;
        document.head.appendChild(styles);

        // Get elements
        this.modal = document.getElementById('clientModal');
        this.form = document.getElementById('clientForm');
        this.closeBtn = document.querySelector('.close-btn');
        this.cancelBtn = document.querySelector('.cancel-btn');
        this.addBtn = document.querySelector('.add-client-btn');
        this.clientSelect = document.querySelector('select[name="client_id"]');

        // Bind events
        this.addBtn.onclick = () => this.openModal();
        this.closeBtn.onclick = () => this.closeModal();
        this.cancelBtn.onclick = () => this.closeModal();
        this.modal.onclick = (e) => {
            if (e.target === this.modal) this.closeModal();
        };
        this.form.onsubmit = (e) => this.handleSubmit(e);
    },

    openModal() {
        this.modal.classList.add('show-modal');
    },

    closeModal() {
        this.modal.classList.remove('show-modal');
        this.form.reset();
    },

    async handleSubmit(e) {
        e.preventDefault();
        const submitBtn = this.form.querySelector('.save-btn');
        submitBtn.disabled = true;
        submitBtn.textContent = 'جاري الحفظ...';

        try {
            const formData = new FormData(this.form);
            const response = await fetch('/clients', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();
            if (data.success) {
                // Add new client to select
                const option = new Option(`${data.client.code} - ${data.client.name}`, data.client.id);
                this.clientSelect.add(option);
                this.clientSelect.value = data.client.id;
                
                // Trigger change event
                const event = new Event('change');
                this.clientSelect.dispatchEvent(event);
                
                this.showMessage('تم إضافة العميل بنجاح', 'success');
                this.closeModal();
            } else {
                this.showMessage('حدث خطأ أثناء إضافة العميل', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showMessage('حدث خطأ أثناء إضافة العميل', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'حفظ';
        }
    },

    showMessage(text, type) {
        const msg = document.createElement('div');
        msg.className = 'alert ' + type;
        msg.textContent = text;
        msg.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            border-radius: 4px;
            color: white;
            background: ${type === 'success' ? '#4CAF50' : '#f44336'};
            z-index: 9999;
        `;
        
        document.body.appendChild(msg);
        setTimeout(() => msg.remove(), 3000);
    }
};

// Initialize when page loads
document.addEventListener('DOMContentLoaded', () => Modal.init());
