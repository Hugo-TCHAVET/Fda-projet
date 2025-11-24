{{-- resources/views/livewire/type_demandeur.blade.php --}}
<div>
    <style>
        #typeDemandeurChart {
            margin-right: 250px;
            /* Ajustez la valeur en fonction de la largeur de votre barre de navigation */
        }

        body {
            padding-left: 250px;
            /* Ajustez la valeur en fonction de la largeur de votre barre de navigation */
        }
    </style>

    <div style="height: 250px; padding: 10px">
        <canvas id="typeDemandeurChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var typeDemandeurData = @json($data);
        var typeDemandeurLabels = typeDemandeurData.map(function(item) {
            return item.type_demande;
        });
        var typeDemandeurPercentages = typeDemandeurData.map(function(item) {
            return item.percentage;
        });

        var typeDemandeurCtx = document.getElementById('typeDemandeurChart').getContext('2d');

        var typeDemandeurChart = new Chart(typeDemandeurCtx, {
            type: 'bar',
            data: {
                labels: typeDemandeurLabels,
                datasets: [{
                    label: 'Pourcentage de demandes par type de demandeur',
                    data: typeDemandeurPercentages,
                    backgroundColor: 'rgba(250, 119, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    barPercentage: 0.4,
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