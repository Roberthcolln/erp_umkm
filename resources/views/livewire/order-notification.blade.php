<span wire:poll.3s>
    @if ($newPesanCount > 0)
    <span
        id="badge-pesan"

        style="color: red; font-weight: bold; font-size: 1.0rem;">
        <i class="fas fa-cash-register animate-bounce"></i>

        <span class="ml-1"><small>{{ $newPesanCount }}</small></span>
    </span>
    @endif

    <style>
        /* Animasi shake */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-3px);
            }

            50% {
                transform: translateX(3px);
            }

            75% {
                transform: translateX(-3px);
            }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        /* Ikon animasi bounce */
        .animate-bounce {
            animation: bounce 1.0s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }
    </style>



</span>