<div>
    <div>
        <canvas id="sexeChart"></canvas>
    </div>
    <style>
        #departementChart {
            margin-right: 100px;
        }

        body {
            padding-left: 300px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var sexeData = @json($data);
        var sexeLabels = sexeData.map(function(item) {
            return item.sexe === 1 ? 'Masculin' : 'Féminin';
        });
        var sexeCounts = sexeData.map(function(item) {
            return item.count;
        });

        var sexeCtx = document.getElementById('sexeChart').getContext('2d');

        var sexeChart = new Chart(sexeCtx, {
            type: 'bar',
            data: {
                labels: sexeLabels,
                datasets: [{
                    label: 'Nombre d\'inscriptions par sexe',
                    data: sexeCounts,
                    backgroundColor: 'rgba(255, 206, 86, 0.8)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    barPercentage: 0.3,
                    categoryPercentage: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                        // ... autres options d'échelle pour l'axe y
                    }
                }
            }
        });
    </script>
</div>