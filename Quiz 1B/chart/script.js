document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('myChart');
    const ctx = canvas.getContext('2d');
    const labelInput = document.getElementById('labelInput');
    const valueInput = document.getElementById('valueInput');
    const addDataBtn = document.getElementById('addDataBtn');

    let labels = ["January", "February", "March", "April", "May"];
    let data = [10, 20, 15, 25, 30];

    function showMessage(message, type = 'error') {
        alert(message);
    }

    function drawChart() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        const padding = 40;
        const chartWidth = canvas.width - 2 * padding;
        const chartHeight = canvas.height - 2 * padding;

        ctx.beginPath();
        ctx.lineWidth = 2;
        ctx.moveTo(padding, padding);
        ctx.lineTo(padding, canvas.height - padding);
        ctx.lineTo(canvas.width - padding, canvas.height - padding);
        ctx.stroke();

        const maxValue = Math.max(...data);
        const yAxisScale = chartHeight / (maxValue > 0 ? maxValue * 1.1 : 10);

        ctx.fillStyle = '#333';
        ctx.font = '12px Arial';
        const numYLabels = 5;
        for (let i = 0; i <= numYLabels; i++) {
            const yValue = (maxValue / numYLabels) * i;
            const yPos = canvas.height - padding - (yValue * yAxisScale);
            ctx.fillText(Math.round(yValue), padding - 30, yPos + 5);
        }

        const labelSpacing = chartWidth / (labels.length - 1);
        labels.forEach((label, index) => {
            const xPos = padding + index * labelSpacing;
            ctx.fillText(label, xPos - (ctx.measureText(label).width / 2), canvas.height - padding + 20);
        });

        ctx.beginPath();
        ctx.strokeStyle = 'blue';
        ctx.lineWidth = 2;

        data.forEach((value, index) => {
            const x = padding + index * labelSpacing;
            const y = canvas.height - padding - (value * yAxisScale);

            if (index === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });
        ctx.stroke();
    }

    drawChart();

    addDataBtn.addEventListener('click', async () => {
        const newLabel = labelInput.value.trim();
        const newValue = parseFloat(valueInput.value.trim());

        if (!newLabel || isNaN(newValue)) {
            showMessage('Please enter both a label and a valid numeric value.', 'error');
            return;
        }

        try {
            const response = await fetch('add_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ label: newLabel, value: newValue }),
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                labels = result.labels;
                data = result.data;
                drawChart();
                labelInput.value = '';
                valueInput.value = '';
                showMessage('Data added successfully!', 'success');
            } else {
                showMessage(result.message || 'Failed to add data.', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showMessage('An error occurred while adding data.', 'error');
        }
    });
});
