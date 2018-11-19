<div id="ice_page_trace" style="position: fixed;bottom:0;right:0;font-size:14px;width:100%;z-index: 999999;color: #000;text-align:left;font-family:'微软雅黑';">
    <div id="ice_page_trace_tab" style="display: none; background: white; margin: 0px; height: 250px;border:1px solid #adadad;">
        <div id="ice_page_trace_tab_tit" style="background: #e2e2e2;height:38px;padding: 6px 12px 0;border-bottom:2px solid #a9a9a9;border:1px solid #adadad;font-size:16px">
            <span style="color: rgb(0, 0, 0); padding-right: 12px; height: 30px; line-height: 30px; display: inline-block; margin-right: 3px; cursor: pointer; font-weight: 700;">基本</span>
            <!--
            <span style="color: rgb(153, 153, 153); padding-right: 12px; height: 30px; line-height: 30px; display: inline-block; margin-right: 3px; cursor: pointer; font-weight: 700;">文件</span>
            <span style="color: rgb(153, 153, 153); padding-right: 12px; height: 30px; line-height: 30px; display: inline-block; margin-right: 3px; cursor: pointer; font-weight: 700;">流程</span>
            -->
            <span style="color: rgb(153, 153, 153); padding-right: 12px; height: 30px; line-height: 30px; display: inline-block; margin-right: 3px; cursor: pointer; font-weight: 700;">SQL</span>
            <span style="color: rgb(153, 153, 153); padding-right: 12px; height: 30px; line-height: 30px; display: inline-block; margin-right: 3px; cursor: pointer; font-weight: 700;">缓存</span>
            <span style="color: rgb(153, 153, 153); padding-right: 12px; height: 30px; line-height: 30px; display: inline-block; margin-right: 3px; cursor: pointer; font-weight: 700;">网络</span>
            <span style="color: rgb(153, 153, 153); padding-right: 12px; height: 30px; line-height: 30px; display: inline-block; margin-right: 3px; cursor: pointer; font-weight: 700;">其它</span>
            <span style="color: rgb(153, 153, 153); padding-right: 12px; height: 30px; line-height: 30px; display: inline-block; margin-right: 3px; cursor: pointer; font-weight: 700;">研发团队</span>
            <span style="color: rgb(153, 153, 153); padding-right: 12px; height: 30px; line-height: 30px; display: inline-block; margin-right: 3px; cursor: pointer; font-weight: 700;"><a href="/?m=system&c=index&a=view" target="_blank">系统功能</a></span>
            <!--
            <span style="color: rgb(153, 153, 153); padding-right: 12px; height: 30px; line-height: 30px; display: inline-block; margin-right: 3px; cursor: pointer; font-weight: 700;">调试</span>
            -->
        </div>
        <div id="ice_page_trace_tab_cont" style="overflow:auto;height:212px;padding: 0; line-height: 24px">
            <div style="display: block;">
                <ol style="padding: 0; margin:0">

                    <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px">运行时间 : <?=$persist?>s.</li>
                    <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px">内存开销 : <?=$usage?></li>
                    <!--
                    <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px">吞吐率 : req/s</li>
                    <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px">请求信息 : 2017-09-12 21:37:38 HTTP/1.1 GET : xxxxxx.com/xxx/xxx</li>
                    <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px">查询信息 : 0 queries 0 writes </li>
                    <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px">文件加载 : 0 </li>
                    <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px">缓存信息 : 0 gets 0 writes </li>
                    <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px">配置加载 : 0</li>
                    -->
                    <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px">会话信息 : SESSION_ID = <?=session_id()?></li>    </ol>
            </div>
            <div style="display:none;">
                <ol style="padding: 0; margin:0">
                    <?php foreach($sqls as $k=>$msg): ?>
                    <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px"><?php echo json_encode($msg,JSON_UNESCAPED_UNICODE) ?></li>
                    <?php endforeach ?>
                </ol>
            </div>
            <div style="display: none">
                <ol style="padding: 0; margin:0">
                    <?php foreach($caches as $k=>$msg): ?>
                        <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px"><?php echo json_encode($msg,JSON_UNESCAPED_UNICODE) ?></li>
                    <?php endforeach ?>
                </ol>
            </div>
            <div style="display: none">
                <ol style="padding: 0; margin:0">
                    <?php foreach($nets as $k=>$msg): ?>
                        <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px"><?php echo json_encode($msg,JSON_UNESCAPED_UNICODE) ?></li>
                    <?php endforeach ?>
                </ol>
            </div>
            <div style="display:none;">
                <ol style="padding: 0; margin:0">
                    <?php foreach($others as $k=>$msg): ?>
                        <li style="border-bottom:1px solid #EEE;font-size:14px;padding:0 12px"><?php echo json_encode($msg,JSON_UNESCAPED_UNICODE) ?></li>
                    <?php endforeach ?>
                </ol>
            </div>

            <div style="display:none;">
                <ol style="padding: 0; margin:0">
                    <li>产品经理:猛哥</li><li>
                        研发经理:蓝冰大侠</li><li>
                        产品小妹:秋宏</li><li>
                        程序猿:姚旋</li><li>
                        程序猿:张强</li><li>
                        程序猿:吕磊博</li><li>
                        程序猿:王申召</li><li>
                        程序媛:阿顿</li>

                </ol>
            </div>

        </div>
    </div>
    <div id="ice_page_trace_close" style="display: none; text-align: right; height: 15px; position: absolute; top: 10px; right: 12px; cursor: pointer;"><img style="vertical-align:top;" src="data:image/gif;base64,R0lGODlhDwAPAJEAAAAAAAMDA////wAAACH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M1IFdpbmRvd3MiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MUQxMjc1MUJCQUJDMTFFMTk0OUVGRjc3QzU4RURFNkEiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MUQxMjc1MUNCQUJDMTFFMTk0OUVGRjc3QzU4RURFNkEiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDoxRDEyNzUxOUJBQkMxMUUxOTQ5RUZGNzdDNThFREU2QSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDoxRDEyNzUxQUJBQkMxMUUxOTQ5RUZGNzdDNThFREU2QSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PgH//v38+/r5+Pf29fTz8vHw7+7t7Ovq6ejn5uXk4+Lh4N/e3dzb2tnY19bV1NPS0dDPzs3My8rJyMfGxcTDwsHAv769vLu6ubi3trW0s7KxsK+urayrqqmop6alpKOioaCfnp2cm5qZmJeWlZSTkpGQj46NjIuKiYiHhoWEg4KBgH9+fXx7enl4d3Z1dHNycXBvbm1sa2ppaGdmZWRjYmFgX15dXFtaWVhXVlVUU1JRUE9OTUxLSklIR0ZFRENCQUA/Pj08Ozo5ODc2NTQzMjEwLy4tLCsqKSgnJiUkIyIhIB8eHRwbGhkYFxYVFBMSERAPDg0MCwoJCAcGBQQDAgEAACH5BAAAAAAALAAAAAAPAA8AAAIdjI6JZqotoJPR1fnsgRR3C2jZl3Ai9aWZZooV+RQAOw==" alt="关闭"></div>
</div>

<div id="ice_page_trace_open" style="height: 30px; float: right; text-align: right; overflow: hidden; position: fixed; bottom: 0px; right: 0px; color: rgb(0, 0, 0); line-height: 30px; cursor: pointer; z-index: 9999; display: block;">
    <div style="background:#000000;color:#FFF;padding:0 6px;float:right;line-height:30px;font-size:14px">
        <?=$persist?>s.
    </div>
    <img height="30" style="vertical-align:top;" title="ShowPageTrace" src="data:image/jpg;base64,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" alt="调试信息">
</div>


<script type="text/javascript">
    (function(){
        var tab_tit  = document.getElementById('ice_page_trace_tab_tit').getElementsByTagName('span');
        var tab_cont = document.getElementById('ice_page_trace_tab_cont').getElementsByTagName('div');
        var open     = document.getElementById('ice_page_trace_open');
        var close    = document.getElementById('ice_page_trace_close').childNodes[0];
        var trace    = document.getElementById('ice_page_trace_tab');
        var cookie   = document.cookie.match(/ice_show_page_trace=(\d\|\d)/);
        var history  = (cookie && typeof cookie[1] != 'undefined' && cookie[1].split('|')) || [0,0];
        open.onclick = function(){
            trace.style.display = 'block';
            this.style.display = 'none';
            close.parentNode.style.display = 'block';
            history[0] = 1;
            document.cookie = 'ice_show_page_trace='+history.join('|')
        }
        close.onclick = function(){
            trace.style.display = 'none';
            this.parentNode.style.display = 'none';
            open.style.display = 'block';
            history[0] = 0;
            document.cookie = 'ice_show_page_trace='+history.join('|')
        }
        for(var i = 0; i < tab_tit.length; i++){
            tab_tit[i].onclick = (function(i){
                return function(){
                    for(var j = 0; j < tab_cont.length; j++){
                        tab_cont[j].style.display = 'none';
                        tab_tit[j].style.color = '#999';
                    }
                    tab_cont[i].style.display = 'block';
                    tab_tit[i].style.color = '#000';
                    history[1] = i;
                    document.cookie = 'ice_show_page_trace='+history.join('|')
                }
            })(i)
        }
        parseInt(history[0]) && open.click();
        (tab_tit[history[1]] || tab_tit[0]).click();
    })();
</script>