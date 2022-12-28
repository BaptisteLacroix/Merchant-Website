const data = [];
const data2 = [];
const months = {
    1: 'Jan',
    2: 'Feb',
    3: 'Mar',
    4: 'Apr',
    5: 'May',
    6: 'Jun',
    7: 'Jul',
    8: 'Aug',
    9: 'Sep',
    10: 'Oct',
    11: 'Nov',
    12: 'Dec',
}
// Get the current month
const currentMonth = new Date().getMonth() + 1;
for (let i = 1; i <= currentMonth; i++) {
    let v = 0;
    if (ventes[i] != null) {
        v = ventes[i];
    }
    data.push({x: i, y: v});
    let a = 0;
    if (achats[i] != null) {
        a = achats[i];
    }
    data2.push({x: i, y: a});
}

const totalDuration = 1000;
const delayBetweenPoints = totalDuration / data.length;
const previousY = (ctx) => ctx.index === 0 ? ctx.chart.scales.y.getPixelForValue(100) : ctx.chart.getDatasetMeta(ctx.datasetIndex).data[ctx.index - 1].getProps(['y'], true).y;

const ctx = document.getElementById('revenueMonth');


new Chart(ctx, {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Sales',
            borderColor: '#456aff',
            borderWidth: 2,
            radius: 1,
            data: data,
        },
            {
                label: 'Purchases',
                borderColor: 'red',
                borderWidth: 2,
                radius: 1,
                data: data2,
            }]
    },
    options: {
        maintainAspectRatio: true, // Enable the aspect ratio
        responsive: true, // Enable responsive behavior
        title: {
            display: true,
            text: 'Sales and Purchases per month for the current year',
        },
        animation: {
            x: {
                type: 'number',
                easing: 'linear',
                duration: delayBetweenPoints,
                from: NaN, // the point is initially skipped
                delay(ctx) {
                    if (ctx.type !== 'data' || ctx.xStarted) {
                        return 0;
                    }
                    ctx.xStarted = true;
                    return ctx.index * delayBetweenPoints;
                }
            },
            y: {
                type: 'number',
                easing: 'linear',
                duration: delayBetweenPoints,
                from: previousY,
                delay(ctx) {
                    if (ctx.type !== 'data' || ctx.yStarted) {
                        return 0;
                    }
                    ctx.yStarted = true;
                    return ctx.index * delayBetweenPoints;
                }
            }
        },
        interaction: {
            intersect: false
        },
        plugins: {
            legend: true
        },
        scales: {
            x: {
                scaleLabel: {
                    display: true, // Enable the scale label
                    labelString: 'Month' // Set the scale label text
                },
                type: 'linear'
            }
        }
    }
});