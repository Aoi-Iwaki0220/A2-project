@extends('layouts.app')
@section('content')
    <button type="button" onclick="location.href='{{ route('calendar.index')}}'">
        もどる
    </button>

    <div id="pdf-area">
        <h2>{{ $year }}年{{ $month }}月のグラフ</h2>
        @if($top3Categories->isNotEmpty())
            <canvas id="myChart" width="200" height="200"></canvas>

            <p>{{ $year }}年{{ $month }}月は ぜんぶで{{ ($totalAmount) }}円 つかいました。</p>

            <span>1ばん おおかったのは
                [{{ $top3Categories[0]['name'] }}]で{{($top3Categories[0]['amount']) }}円
                <br>次に
                @if(isset($top3Categories[1]))
                    [{{ $top3Categories[1]['name'] }}]で{{($top3Categories[1]['amount']) }}円
                @endif
                <br>@if(isset($top3Categories[2]))
                    [{{ $top3Categories[2]['name'] }}]で{{($top3Categories[2]['amount']) }}円
                @endif
                でした。
            </span>
        @else(!isset)
            <p>この月は データがありません。</p>
        @endif
    </div>

        <button type="button" onclick="generatePDF()">PDFでほぞんする</button>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>

        var graphData = @json($graphData);

        var labels = graphData.map(item => item.label);
        var values = graphData.map(item => item.value);

        var ctx = document.getElementById("myChart");
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'つかったお金のカテゴリ別グラフ',
                    data: values,
                    backgroundColor: ['#ff6347', '#4169e1', '#ffd700', '#008000', '#6a5acd', '#696969' ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {position: 'bottom'},  //カテゴリー色を下に表示
                    tooltip: {enabled: false},
                    datalabels: {  //グラフ内に金額など表示
                        color: '#fff',  //表記スタイル↓
                        formatter: function(value, context) {
                            const label = context.chart.data.labels[context.dataIndex];
                            return label + '\n' + value + '円';
                        },
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        async function generatePDF() {
            const { jsPDF } = window.jspdf;
            const element = document.getElementById("pdf-area");  //PDFにする範囲を取得
            const canvas = await html2canvas(element, { scale: 2 });  //Canvasに変換
            const pdf = new jsPDF();

            const imgData = canvas.toDataURL("image/png");  //canvasをIMGに変換
            const imgProps = pdf.getImageProperties(imgData);  //画像の高さ・幅情報などを取得
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;  //横幅に合わせて高さを自動調整

            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);  //PDFの左上ｎい画像を貼り、サイズをpdfWidth×pdfHeightにする
            pdf.save("つかったお金_{{ $year }}年{{ $month }}月.pdf");  //ファイル名
        }
    </script>
@endsection
    