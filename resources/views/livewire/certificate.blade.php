<div>
    Anda telah mengerjakan TOEFL.. berikut adalah ringkasan hasil pekerjaan alert-secondary
    <ul>
        <li>Soal Section 1 benar / dikerjakan : {{ $score->section1_correct }} / {{ $score->section1_answered }}</li>
        <li>Soal Section 2 benar / dikerjakan : {{ $score->section2_correct }} / {{ $score->section2_answered }}</li>
        <li>Soal Section 3 benar / dikerjakan : {{ $score->section3_correct }} / {{ $score->section3_answered }}</li>
        <li>SKOR AKHIR = {{ $score->final_score }}</li>
    </ul>
</div>
