<style>
    .container {
        max-width: 400px;
        margin: 2rem auto;
        padding: 1.5rem;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .date-filters {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        gap: 1rem;
    }

    .date-filters > div {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    label {
        margin-bottom: 0.4rem;
        font-weight: 600;
        color: #444;
    }

    input[type="date"] {
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
    }

    .summary {
        text-align: center;
    }

    .summary p {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0.7rem 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .pendapatan {
        color: #2d7a2d; /* hijau */
    }

    .pengeluaran {
        color: #a83232; /* merah */
    }

    hr {
        margin: 1.5rem 0;
        border: 0;
        border-top: 1px solid #ddd;
    }

    .saldo {
        font-size: 1.3rem;
        font-weight: 700;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    .saldo.positif {
        color: #2d7a2d;
    }

    .saldo.negatif {
        color: #a83232;
    }
</style>

<div class="container">
    <h2>📋 Ringkasan Keuangan</h2>

    <div class="date-filters">
        <div>
            <label for="tanggalAwal">Tanggal Awal</label>
            <input type="date" id="tanggalAwal" wire:model="tanggalAwal">
        </div>
        <div>
            <label for="tanggalAkhir">Tanggal Akhir</label>
            <input type="date" id="tanggalAkhir" wire:model="tanggalAkhir">
        </div>
    </div>

    <div class="summary">
        <p class="pendapatan">💰 Total Pendapatan: Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        <p class="pengeluaran">📤 Total Pengeluaran: Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</p>

        <hr>

        <p class="saldo {{ $saldo >= 0 ? 'positif' : 'negatif' }}">
            📊 Saldo Saat Ini: Rp{{ number_format($saldo, 0, ',', '.') }}
        </p>
    </div>
</div>
