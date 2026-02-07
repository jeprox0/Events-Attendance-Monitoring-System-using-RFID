<!-- Edit Payment Modal -->
<div class="modal fade" id="editContributionModal" tabindex="-1" aria-labelledby="editContributionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContributionModalLabel">Edit Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPaymentForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    
                    <!-- OR Number (Read-Only) -->
                    <div class="mb-3">
                        <label for="or_number" class="form-label" style="font-weight: bold;">OR #</label>
                        <input type="text" name="or_number" id="edit_or_number" class="form-control" readonly>
                    </div>

                    <!-- Amount Paid -->
                    <div class="mb-3">
                        <label for="amount_paid" class="form-label" style="font-weight: bold;">Amount Paid</label>
                        <input type="number" step="0.01" name="amount_paid" id="edit_amount_paid" class="form-control" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // When the "Edit" button is clicked, populate the modal with the payment data
    $('#editContributionModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);  // Button that triggered the modal

        // Extract info from data-* attributes
        var paymentId = button.data('id');
        var orNumber = button.data('or_number');
        var amountPaid = button.data('amount_paid');

        // Update the modal's form fields
        var modal = $(this);
        modal.find('#edit_or_number').val(orNumber);
        modal.find('#edit_amount_paid').val(amountPaid);

        // Update the form action URL dynamically
        var form = modal.find('#editPaymentForm');
        form.attr('action', '/payments/' + paymentId);  // Update form action with correct ID
    });
</script>
