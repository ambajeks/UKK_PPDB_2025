<!-- Confirmation Modal for Payment -->
<div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg p-8 max-w-md w-full mx-4">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Konfirmasi Pembayaran</h2>
            <p class="text-gray-600">Pastikan data Anda sudah benar sebelum melanjutkan</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Nama Siswa:</span>
                    <span class="font-medium text-gray-800">{{ $formulir->nama_lengkap ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">No. Formulir:</span>
                    <span class="font-medium text-gray-800">{{ $formulir->nomor_pendaftaran ?? '-' }}</span>
                </div>
                <div class="flex justify-between border-t pt-3">
                    <span class="text-gray-600 font-semibold">Total Pembayaran:</span>
                    <span class="font-bold text-green-600 text-lg" id="modal-total-price">Rp 0</span>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                Anda akan diarahkan ke Midtrans untuk menyelesaikan pembayaran. Transaksi Anda dijamin aman.
            </p>
        </div>

        <div class="flex gap-3">
            <button type="button" onclick="closePaymentModal()"
                class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold transition duration-200">
                Batal
            </button>
            <button type="submit" form="paymentForm"
                class="flex-1 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition duration-200 flex items-center justify-center">
                <i class="fas fa-check mr-2"></i>
                Lanjutkan Pembayaran
            </button>
        </div>
    </div>
</div>

<script>
    function openPaymentModal() {
        // Get the current total price and update modal
        const totalPriceElement = document.getElementById('total-price');
        const modalTotalPrice = document.getElementById('modal-total-price');

        if (totalPriceElement && modalTotalPrice) {
            modalTotalPrice.textContent = totalPriceElement.textContent;
        }

        // Show modal
        document.getElementById('paymentModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when pressing Escape key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closePaymentModal();
        }
    });

    // Close modal when clicking outside
    document.getElementById('paymentModal').addEventListener('click', function (event) {
        if (event.target === this) {
            closePaymentModal();
        }
    });
</script>