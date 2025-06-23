{{-- resources/views/livewire/service.blade.php --}}
<div>
    <div>
        <canvas id="serviceChart"></canvas>
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
        var serviceData = @json($data);
        var serviceLabels = serviceData.map(function(item) { return item.service; });
        var serviceCounts = serviceData.map(function(item) { return item.count; });

        var serviceCtx = document.getElementById('serviceChart').getContext('2d');

        var serviceChart = new Chart(serviceCtx, {
            type: 'bar',
            data: {
                labels: serviceLabels,
                datasets: [{
                    label: 'Nombre de demandes par service',
                    data: serviceCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        // ... autres options d'échelle pour l'axe y
                    }
                }
            }
        });
    </script>
</div>
