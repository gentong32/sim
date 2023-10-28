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
    <div class="question-container">
        <div class="question" id="question1">
            <h2>Soal 1</h2>
            <label>
                <input type="radio" name="question1" value="A"> Opsi A
            </label><br>
            <label>
                <input type="radio" name="question1" value="B"> Opsi B
            </label><br>
            <label>
                <input type="radio" name="question1" value="C"> Opsi C
            </label><br>
            <label>
                <input type="radio" name="question1" value="D"> Opsi D
            </label><br>
            <label>
                <input type="radio" name="question1" value="E"> Opsi E
            </label><br>
        </div>
        <div class="question" id="question2">
            <h2>Soal 2</h2>
            <label>
                <input type="radio" name="question2" value="A"> Opsi 2A
            </label><br>
            <label>
                <input type="radio" name="question2" value="B"> Opsi 2B
            </label><br>
            <label>
                <input type="radio" name="question2" value="C"> Opsi 2C
            </label><br>
            <label>
                <input type="radio" name="question2" value="D"> Opsi 2D
            </label><br>
            <label>
                <input type="radio" name="question2" value="E"> Opsi 2E
            </label><br>
        </div>
        <div class="question" id="question3">
            <h2>Soal 3</h2>
            <label>
                <input type="radio" name="question3" value="A"> Opsi 3A
            </label><br>
            <label>
                <input type="radio" name="question3" value="B"> Opsi 3B
            </label><br>
            <label>
                <input type="radio" name="question3" value="C"> Opsi 3C
            </label><br>
            <label>
                <input type="radio" name="question3" value="D"> Opsi 3D
            </label><br>
            <label>
                <input type="radio" name="question3" value="E"> Opsi 3E
            </label><br>
        </div>
    </div>
</div>
<button onclick="previousQuestion()">Soal Sebelumnya</button>
<button onclick="nextQuestion()">Soal Berikutnya</button>

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