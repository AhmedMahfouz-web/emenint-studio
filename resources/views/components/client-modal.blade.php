<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal">
    <i class="fas fa-plus"></i> عميل جديد
</button>

<style>
.modal-backdrop {
    display: none !important;
}
body.modal-open {
    overflow: auto !important;
    padding-right: 0 !important;
}
</style>

<!-- Modal -->
<div class="modal fade" id="createClientModal" tabindex="-1" aria-labelledby="createClientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClientModalLabel">إضافة عميل جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createClientForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">اسم العميل *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">رقم الهاتف *</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">الدولة *</label>
                        <input type="text" class="form-control" id="country" name="country" required>
                    </div>
                    <div class="mb-3">
                        <label for="company" class="form-label">الشركة</label>
                        <input type="text" class="form-control" id="company" name="company">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">العنوان</label>
                        <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createClientForm');
    const modal = document.getElementById('createClientModal');
    const bsModal = new bootstrap.Modal(modal);
    
    function cleanupModal() {
        // Force remove backdrop
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        
        // Clean up body
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
        
        // Reset form
        form.reset();
        
        // Hide modal
        modal.classList.remove('show');
        modal.style.display = 'none';
    }
    
    modal.addEventListener('hidden.bs.modal', cleanupModal);
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري الحفظ...';

        const formData = new FormData(this);
        
        fetch("{{ url('/invoice/clients') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add new client to select
                const clientSelect = document.querySelector('select[name="client_id"]');
                if (clientSelect) {
                    const option = new Option(`${data.client.code} - ${data.client.name}`, data.client.id);
                    option.dataset.code = data.client.code;
                    clientSelect.add(option);
                    clientSelect.value = data.client.id;
                    clientSelect.dispatchEvent(new Event('change'));
                }
                
                // Clean up modal
                cleanupModal();
                
                // Show success notification
                toastr.success('تم إضافة العميل بنجاح', 'نجاح');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('حدث خطأ أثناء إضافة العميل', 'خطأ');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'حفظ';
        });
    });
    
    // Additional cleanup on page load
    cleanupModal();
});
</script>
@endpush