<div class="center">

<div class="border m_marg vs_padd">
<p class="bold">Clear Cache</p>
  <a href="javascript:void(0)" onclick="cache('general','{csrf_token}')">{@lang('Database and other data')@}</a> &nbsp; &bull; &nbsp;
  <a href="javascript:void(0)" onclick="cache('tpl_compile','{csrf_token}')">{@lang('Compile Template')@}</a> &nbsp; &bull; &nbsp;
  <a href="javascript:void(0)" onclick="cache('tpl_html','{csrf_token}')">{@lang('HTML Template')@}</a> &nbsp; &bull; &nbsp;
  <a href="javascript:void(0)" onclick="cache('static','{csrf_token}')">{@lang('Static Files')@}</a>
</div>

  <div class="border s_marg">
  <script src="https://www.google.com/jsapi"></script>
  <script>
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(showCacheChart);

    function showCacheChart()
    {
        $('#cache_chart').html('');

        var oDataTable = new google.visualization.DataTable();
        oDataTable.addColumn('string', 'Cache');
        oDataTable.addColumn('number', 'Size');
        var aData = [
            {@foreach($aChartData as $aData)@}
                ["{% $aData['title'] %}", {v:{% $aData['size'] %}, f:"{% Framework\File\Various::bytesToSize($aData['size']) %}"}],
            {@/foreach@}
        ];
        oDataTable.addRows(aData);
        new google.visualization.PieChart($('#cache_chart')[0]).draw(oDataTable);
    }
  </script>

  <div id="cache_chart"></div>
  </div>

</div>
