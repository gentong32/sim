<?php
$data = [
    ["judul" => "Modul 1", "file" => "/uploads/example.pdf"],
    ["judul" => "Modul 2", "file" => "/uploads/example2.pdf"],
    // Tambahkan modul-modul lainnya di sini
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Modul PDF</title>
    <script src="/node_modules/pdfjs-dist/build/pdf.js"></script>
    <style>
        #modules {
            display: flex;
            margin: 20px;
            align-items: flex-start;
            justify-content: center;
        }

        .module {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: 20px;
        }

        .thumbnail {
            max-width: 200px;
            max-height: 200px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div id="modules">
        <?php
        $idx = 0;
        foreach ($data as $module) :
            $idx++;
        ?>
            <div class="module" id="Modul<?= $idx ?>">
                <h2><?= $module['judul'] ?></h2>
                <canvas class="thumbnail"></canvas>
            </div>
        <?php endforeach; ?>
    </div>

    <form action="<?= base_url('upload') ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="pdf_file" accept=".pdf">
        <button type="submit">Unggah</button>
    </form>

    <script>
        var modulesData = <?php echo json_encode($data); ?>;

        document.addEventListener('DOMContentLoaded', function() {
            const pdfjsLib = window['pdfjs-dist/build/pdf'];
            var idx = 0;
            modulesData.forEach(module => {
                idx++;
                const thumbnail = document.querySelector(`#Modul` + idx + ` .thumbnail`);

                pdfjsLib.getDocument(module.file).promise.then(pdf => {
                    pdf.getPage(1).then(page => {
                        const viewport = page.getViewport({
                            scale: 0.5
                        });
                        const canvas = thumbnail;
                        const context = canvas.getContext('2d');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        page.render({
                            canvasContext: context,
                            viewport: viewport
                        });
                    });
                });
            });
        });
    </script>
</body>

</html>