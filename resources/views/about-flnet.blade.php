@extends('layouts.authAbout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="txt-content">

                <center><img src="../images/img_logo_flnet.svg" width="80">
                    <h3 class="big-title">关于富连网</h3></center>
                <div class="content rule">
                    <p><b>公司简介</b></p>
                    <p>富连网商城成立于2013年4月，是富士康科技集团旗下的综合电商平台。依托富士康强大的制造力，主要经营夏普、苹果、诺基亚等自主及合作品牌商品。我们秉承“货真、价实、良品、承诺、体验、服务 ”的企业理念，励志在五年内将富连网打造为集购物、娱乐、售后的一站式“智能家居服务平台” 。</p>
                    <br>
                    <p><b>大事记</b></p>
                    <ul class="history">
                        <li><b>2013年4月</b>富连网正式成立，总部设于深圳</li>
                        <li><b>2013年7月</b>自营平台上线，域名flnet.com</li>
                        <li><b>2014年6月</b>天猫618大促-自主品牌富可视手机销量第三，平板销量第一</li>
                        <li><b>2015年4月</b>富连网成为苹果官方二手机独家授权销售渠道，预约总人数达200万</li>
                        <li><b>2015年9月</b>富连网APP正式上线</li>
                        <li><b>2015年10月</b>富士康联合阿里云推出“淘富成真”项目，为中小智能终端及创客提供创业服务</li>
                        <li><b>2016年4月</b>富连网在全国开设线下门店450家，体验店达5000个</li>
                        <li><b>2017年3月</b>富连网联手“夏普”推出“夏普会员回富士康娘家-电视以旧换新“服务，展开富士康   入股夏普的第一个大型市场营销活动</li>
                    </ul>
                    <br>
                    <p><b>经营宗旨</b></p>
                    <ol>
                        <li>重品质<br>货真、价实、良品、承诺、体验、服务是我们服务准则，争做全生态一站式“智能家居服务平台”</li>
                        <li>重数据<br>积累用户使用大数据，转化为产品设计服务数据</li>
                        <li>重服务<br>从用户体验出发为会员提供可持续的售后增值服务，不易会员数量为考量，重视用户黏着度</li>
                        <li>重责任<br>推动循环经济发展，活化再生资源，善尽企业社会责任</li>
                    </ol>
                    <br>
                    <p><b>品牌特色</b></p>
                    <ol>
                        <li>自营平台<br>
                            <ul>
                                <li>1) 精选商品</li>
                                <li>2) 实物体验</li>
                                <li>3) 新品试用</li>
                                <li>4) 达人教学</li>
                                <li>5) 会员活动</li>
                                <li>6) 环保回收</li>
                            </ul>
                        </li>
                        <li>品牌旗舰店
                            <ul>
                                <li>1) 自主品牌，工厂直供</li>
                                <li>2) 粉丝福利专享</li>
                                <li>3) 达人服务</li>
                            </ul>
                        </li>
                        <li>线下体验点
                            <ul>
                                <li>1) 正品保证</li>
                                <li>2) 海量试用群体</li>
                                <li>3) 线下回收</li>
                                <li>4) 完善维修售后</li>
                            </ul>
                        </li>
                    </ol>
                    <br>
                    <p><b>富连网相关服务</b></p>
                    <div id="link"></div>

                </div>
            </div>

        </div><!-- container -->



    </div>
    <!--.container -->

    <div id="waiting-popup" class="overlay">
        <div class="popup">
            <a class="btn-close" href="#"></a>
            <div class="content">
                <a class="close" href="#"><img src="images/bg_waiting.png" width="100%"></a>
            </div>
        </div>
    </div>

    <!--
        JavaScripts
        ========================== -->
    <!-- main jQuery -->
    <script src="js/jquery.min.js"></script>
    <script>
        $( document ).ready(function() {
            $('#link').load('{{ url('linkflnet') }} .link-content');
        });
    </script>
@endsection
