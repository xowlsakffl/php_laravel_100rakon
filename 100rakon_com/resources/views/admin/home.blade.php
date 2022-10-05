@extends('admin.layouts.app')

@section('content')
<div class="section_wrap">
    <div class="content_box mbox">
        <div class="main_wrap home_box">
            <div class="chart">
                <div class="chart_top clearfix">
                    <div class="chart_title">차트</div>
                    {{--<div class="chart_date classify">
                            <ul class="clearfix">
                                <li><a href="" class="active">주간</a></li>
                                <li><a href="">월간</a></li>
                                <li><a href="">분기</a></li>
                                <li><a href="">반기</a></li>
                            </ul>
                        </div> --}}
                </div>
                <div class="chart_box">
                    <div class="chart_content chart1">
                        <canvas id="myChart1"></canvas>
                    </div>
                    <div class="chart_content chart2">
                        <canvas id="myChart2"></canvas>
                    </div>
                </div>
                <script type="text/javascript">
                    var chartData_1 = @json($chart1);
                    var maxData = Math.max.apply(null,chartData_1);
                    console.log(maxData);
                    var context1 = document
                        .getElementById('myChart1')
                        .getContext('2d');
                    var myChart1 = new Chart(context1, {
                        type: 'line', // 차트의 형태
                        data: { // 차트에 들어갈 데이터
                            labels: [
                                //x 축
                                '7일전','6일전','5일전','4일전','3일전','2일전','1일전','오늘'
                            ],
                            datasets: [
                                { //데이터
                                    label: '1주일간 매출 차트', //차트 제목
                                    fill: false, // line 형태일 때, 선 안쪽을 채우는지 안채우는지
                                    data: chartData_1,
                                    backgroundColor: [
                                        //색상
                                        'rgba(255, 99, 132, 0.2)',
                                    ],
                                    borderColor: [
                                        //경계선 색상
                                        'rgba(255, 99, 132, 1)',
                                    ],
                                    borderWidth: 1 //경계선 굵기
                                }
                            ]
                        },
                        options: {
                            scales: {
                                yAxes: [
                                    {
                                        ticks: {
                                            beginAtZero: true,
                                            suggestedMax: maxData * 110/100
                                        }
                                    }
                                ]
                            }
                        }
                    });

                    var chartData_2 = @json($chart2);
                    var maxData = Math.max.apply(null,chartData_2);
                    console.log(chartData_2);
                    var context2 = document
                        .getElementById('myChart2')
                        .getContext('2d');
                    var myChart2 = new Chart(context2, {
                        type: 'line', // 차트의 형태
                        data: { // 차트에 들어갈 데이터
                            labels: [
                                //x 축
                                '7일전','6일전','5일전','4일전','3일전','2일전','1일전','오늘'
                            ],
                            datasets: [
                                { //데이터
                                    label: '1주일간 회원가입 차트', //차트 제목
                                    fill: false, // line 형태일 때, 선 안쪽을 채우는지 안채우는지
                                    data: chartData_2,
                                    backgroundColor: [
                                        //색상
                                        'rgba(255, 99, 222, 0.2)',
                                    ],
                                    borderColor: [
                                        //경계선 색상
                                        'rgba(255, 99, 222, 1)',
                                    ],
                                    borderWidth: 1 //경계선 굵기
                                }
                            ]
                        },
                        options: {
                            scales: {
                                
                                yAxes: [
                                    {
                                        
                                        ticks: {
                                            beginAtZero: true,
                                            stepSize: 1,
                                            suggestedMax: maxData * 110/100
                                        }
                                    }
                                ]
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>

    {{-- <div class="content_box sbox clearfix"> --}}
        {{-- <div class="main_wrap home_box">
            <div class="box_left">
                <div class="box_icon box_icon_color1">
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>
            <div class="box_right">
                <h5>가입자</h5>
                <p class="box_text1">오늘 0명</p>
                <p class="box_text2">전체 0명</p>
            </div>
        </div>
    
        <div class="main_wrap home_box">
            <div class="box_left">
                <div class="box_icon box_icon_color2">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>
            <div class="box_right">
                <h5>프로젝트</h5>
                <p class="box_text1">오늘 0건</p>
                <p class="box_text2">전체 0건</p>
            </div>
        </div>
    
        <div class="main_wrap home_box">
            <div class="box_left">
                <div class="box_icon box_icon_color1">
                    <i class="fas fa-folder-open"></i>
                </div>
            </div>
            <div class="box_right">
                <h5>파일</h5>
                <p class="box_text1">오늘 0개</p>
                <p class="box_text2">전체 0개</p>
            </div>
        </div>

        <div class="main_wrap home_box">
            <div class="box_left">
                <div class="box_icon box_icon_color2">
                    <i class="fas fa-cash-register"></i>
                </div>
            </div>
            <div class="box_right">
                <h5>결제</h5>
                <p class="box_text1">금월 0건</p>
                <p class="box_text2">평균 0건</p>
            </div>
        </div>

        <div class="main_wrap home_box">
            <div class="box_left">
                <div class="box_icon box_icon_color2">
                    <i class="fas fa-chart-pie"></i>
                </div>
            </div>
            <div class="box_right">
                <h5>CPU</h5>
                <p class="box_text1">현재 사용량</p>
                <p class="box_text2">코어 수</p>
            </div>
        </div>

        <div class="main_wrap home_box">
            <div class="box_left">
                <div class="box_icon box_icon_color1">
                    <i class="fas fa-memory"></i>
                </div>
            </div>
            <div class="box_right">
                <h5>Memory</h5>
                <p class="box_text1">현재 사용 0GB</p>
                <p class="box_text2">전체 용량 0GB</p>
            </div>
        </div>

        <div class="main_wrap home_box">
            <div class="box_left">
                <div class="box_icon box_icon_color2">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="box_right">
                <h5>Traffic</h5>
                <p class="box_text1">오늘 0MB</p>
            </div>
        </div>

        <div class="main_wrap home_box">
            <div class="box_left">
                <div class="box_icon box_icon_color1">
                    <i class="fas fa-archive"></i>
                </div>
            </div>
            <div class="box_right">
                <h5>Hard Disk</h5>
                <p class="box_text1">현재 0GB</p>
                <p class="box_text2">전체 0GB</p>
            </div>
        </div>
    </div> --}}
    <div class="home_box_container">
        <div class="main_wrap home_box">
            <div class="alarm">
                <div class="alarm_top clearfix">
                    <div class="alarm_title">
                        <h5>일반구매</h5>
                    </div>
                </div>
                <div class="alarm_content">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>주문번호</th>
                                <th>주문자</th>
                                <th>상태</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr onclick="location.href='{{route('admin.orders.show', ['odx' => $order['odx']])}}'">
                                <td>{{$order['order_number']}}</td>
                                <td>{{$order['order_name']}}</td>
                                <td>
                                    @if ($order['state'] == 10)
                                        입금대기
                                    @elseif($order['state'] == 9)
                                        입금완료
                                    @elseif($order['state'] == 1)
                                        주문취소
                                    @elseif($order['state'] == 0)
                                        삭제
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            
                    <div class="pagenation">
                    </div>
                </div>
            </div>
        </div>
        <div class="main_wrap home_box">
            <div class="alarm">
                <div class="alarm_top clearfix">
                    <div class="alarm_title">
                        <h5>정기배송</h5>
                    </div>
                </div>
                <div class="alarm_content">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>주문번호</th>
                                <th>주문자</th>
                                <th>상태</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscribeOrders as $order)
                            <tr onclick="location.href='{{route('admin.subscrib-orders.show', ['sodx' => $order['sodx']])}}'">
                                <td>{{$order['order_number']}}</td>
                                <td>{{$order['order_name']}}</td>
                                <td>
                                    @if ($order['state'] == 10)
                                        입금대기
                                    @elseif($order['state'] == 9)
                                        입금완료
                                    @elseif($order['state'] == 1)
                                        주문취소
                                    @elseif($order['state'] == 0)
                                        삭제
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            
                    <div class="pagenation">
                    </div>
                </div>
            </div>
        </div>
        <div class="main_wrap home_box">
            <div class="alarm">
                <div class="alarm_top clearfix">
                    <div class="alarm_title">
                        <h5>고객문의</h5>
                    </div>
                </div>
                <div class="alarm_content">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>문의내용</th>
                                <th>이름</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($qnas as $qna)
                            <tr onclick="location.href='{{route('admin.qnas.show', ['idx' => $qna['idx']])}}'">
                                <td>
                                    @php
                                    $str = mb_strimwidth($qna['content'],0,30,"...", 'utf-8');
                                    @endphp
                                    {{$str}}
                                </td>
                                <td>{{$qna['name']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            
                    <div class="pagenation">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
