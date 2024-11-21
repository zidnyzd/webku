<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-xxxx"></script>
<script>
    snap.pay('<?= $snapToken ?>', {
        onSuccess: function(result) {
            alert("Pembayaran berhasil!");
            window.location.href = "<?= base_url('warga/bukti_pembayaran') ?>";
        },
        onPending: function(result) {
            alert("Menunggu pembayaran...");
        },
        onError: function(result) {
            alert("Pembayaran gagal.");
        }
    });
</script>
