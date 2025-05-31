<span wire:poll.3s>
    @if ($jumlahStokMenipis > 0)
        <span
            id="badge-pesan"
            style="color: red; font-weight: bold; font-size: 1.0rem;"
            class="shake"
        >
            <i class="fas fa-exclamation-circle animate-bounce"></i>
            <span class="ml-1"><small>{{ $jumlahStokMenipis }}</small></span>
        </span>
    @endif

    <!-- Elemen audio -->
    <audio id="alertAudio" src="{{ asset('web/sounds/notif-sound.mp3') }}"></audio>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-3px); }
            50% { transform: translateX(3px); }
            75% { transform: translateX(-3px); }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        .animate-bounce {
            animation: bounce 1.0s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
    </style>
</span>

@push('scripts')
<script>
    // Inisialisasi jumlah sebelumnya
    let jumlahSebelumnya = 0;

    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', (message, component) => {
            const jumlahBaru = @js($jumlahStokMenipis);

            if (jumlahBaru > jumlahSebelumnya) {
                const audio = document.getElementById('alertAudio');
                if (audio) {
                    audio.play().catch(error => {
                        console.warn("Autoplay gagal, user belum berinteraksi", error);
                    });
                }
            }

            jumlahSebelumnya = jumlahBaru;
        });
    });
</script>
@endpush
