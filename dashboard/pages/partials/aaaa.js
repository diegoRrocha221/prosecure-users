document.getElementById('capture').addEventListener('click', async function() {
    // Captura de tela usando html2canvas
    const canvas = await html2canvas(document.body);

    // Criação do objeto PDF usando pdf-lib
    const { PDFDocument } = PDFLib;
    const pdfDoc = await PDFDocument.create();
    const page = pdfDoc.addPage([canvas.width, canvas.height]);
    const { width, height } = page.getSize();
    const imgBytes = await fetch(canvas.toDataURL('image/png')).then((res) => res.arrayBuffer());
    const img = await pdfDoc.embedPng(imgBytes);
    page.drawImage(img, {
        x: 0,
        y: height,
        width,
        height,
    });

    // Download do PDF
    const pdfBytes = await pdfDoc.save();
    const blob = new Blob([pdfBytes], { type: 'application/pdf' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'invoice.pdf';
    link.click();
});