<?= $this->extend('layout/layout_default') ?>

<?= $this->section('style') ?>
<style>
    :root {
        --ukf: 12px;
    }

    .wadah {
        max-width: 600px;
        margin: auto
    }

    .question-container {
        width: 100%;
        margin-left: 15px;
        margin-right: 15px;
        margin-bottom: 20px;
        border: 0.5px solid gray;
    }

    .question {
        display: none;
        text-align: left;
        padding-left: 15px;
    }

    button {
        margin-right: 10px;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<div class="wadah">
    UNTUK NILAI DAN RAPOT DISINI
</div>

<!-- Tambahkan modul-modul lainnya di sini -->


<?= $this->endSection(); ?>


<?= $this->section('script') ?>
<script>
    let currentQuestion = 1;

    function showQuestion(questionNumber) {
        const questions = document.querySelectorAll('.question');
        questions.forEach(question => question.style.display = 'none');

        const currentQuestionElement = document.getElementById(`question${questionNumber}`);
        if (currentQuestionElement) {
            currentQuestionElement.style.display = 'block';
        }
    }

    function nextQuestion() {
        if (currentQuestion < 5) {
            currentQuestion++;
            showQuestion(currentQuestion);
        }
    }

    function previousQuestion() {
        if (currentQuestion > 1) {
            currentQuestion--;
            showQuestion(currentQuestion);
        }
    }

    // Tampilkan soal pertama secara default
    showQuestion(currentQuestion);
</script>

<?= $this->endSection(); ?>