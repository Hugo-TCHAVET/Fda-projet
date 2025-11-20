<div>
    <div>
        <canvas id="departementChart"></canvas>
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
        var departementData = @json($data);
        var departementLabels = departementData.map(function(item) { return item.nom_departement; }); 
        var departementPercentages = departementData.map(function(item) { return item.percentage; });

        var departementCtx = document.getElementById('departementChart').getContext('2d');

        var departementChart = new Chart(departementCtx, {
            type: 'bar',
            data: {
                labels: departementLabels,
                datasets: [{
                    label: 'Pourcentage de demandes par département',
                    data: departementPercentages,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
    </script>
</div>
