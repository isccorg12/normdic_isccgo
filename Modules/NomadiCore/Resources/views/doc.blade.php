
topic
file_name
author

<?php
 $docs = new Modules\NomadiCore\Doc();
 $all = $docs->all();
 
?>


<div class='row'>
    <div id='table-wrapper'>

        <!--
        <input class="search form-control" placeholder="Search" />
        <br />
        -->
        <div class="table-responsive">
            <table class='table table-hover table-condensed'>
                <thead>
                    <tr>
                    <?php $label4=config::get('nomadic.global.rank');
                    ?>
                    <th>名字</th>
                    <th class="sort -large" data-sort="c1">主題</th>
                    <th>作者</th>
                    <th>被下載次數</th>

                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($all as $doc)
                    <tr id='id' class='docclass' onclick="openModalByUuid('111', 'list')">
                        <td class="c0">
                            <div style='text-overflow: ellipsis; width: 110px; overflow: hidden;'>
                                <a href='/00.iscc.scoring.2018.pdf'  class="seo-link">{{$doc->file_name}}</a>
                            </div>
                        </td>

                        <td class="c1 {{'rank'}}">
                            <?php
                                     echo("<font color='#800000'>$doc->topic</font>");
                                 

                            ?>
                         </td>

                        <td class="c1">
                            <div style='text-overflow: ellipsis; max-width: 90px; overflow: hidden;'>
                                 test
                            </div>
                        </td>
                        <td class="c1">
                            <div style='text-overflow: ellipsis; max-width: 90px; overflow: hidden;'>
                                {{ visits($doc)->count()}} 
                            </div>
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('nomadicore::_mobile-smart-table-head')

<script type="text/javascript">
    var options = {
        valueNames: [ 'c0', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16', 'c17' ]
    };
    new List('table-wrapper', options);
</script>

<script>
    $(document).ready(function(){
        $('.search').change(function(e){
            $.get('/track/search?keyword=' + e.target.value);
        });
    })
</script>

