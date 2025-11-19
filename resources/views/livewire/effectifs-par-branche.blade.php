<div>
    <div>
        <canvas id="effectifsParBrancheChart"></canvas>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var effectifsData = <?php echo json_encode($data); ?>;
        var branchesLabels = effectifsData.map(function(item) {
            return item.nom_branche;
        });
        var effectifsTotals = effectifsData.map(function(item) {
            return item.effectif_total;
        });

        var effectifsCtx = document.getElementById('effectifsParBrancheChart').getContext('2d');

        var effectifsChart = new Chart(effectifsCtx, {
            type: 'bar',
            data: {
                labels: branchesLabels,
                datasets: [{
                    label: 'Effectif total par branche',
                    data: effectifsTotals,
                    backgroundColor: 'rgba(105, 195, 105, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    barPercentage: 0.4,
                    categoryPercentage: 0.95
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 30,
                        }
                    }
                }
            }
        });
    </script>
</div>