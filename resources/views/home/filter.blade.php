<div class="row">
    
    <div class="col-md-12">

            <div class='col-md-6'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker_start'>
                        <input type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker_end'>
                        <input type='text' class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

    </div>

</div>
<div class="row">

    <div class="col-md-3">

        <select style="width: 100%;">
          <?php foreach($clients as $client) { ?>
                <option>Client {{ $client->client_id }}</option>
            <?php } ?>
        </select>

    </div>
    <div class="col-md-3">

        <select multiple style="width: 100%;">
          <?php foreach($categories as $category) { ?>
                <option>Category {{ $category->category_id }}</option>
            <?php } ?>
        </select>

    </div>
    <div class="col-md-3">

        <select multiple style="width: 100%;">
          <?php foreach($labels as $label) { ?>
                <option>Label {{ $label->label_id }}</option>
            <?php } ?>
        </select>

    </div>
    <div class="col-md-3">

        <select>
            <option>Value &lt;=</option>
            <option>Value &gt;=</option>
        </select>
        
        <input type="text" />

    </div>
    
</div>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker_start').datepicker();
        $('#datetimepicker_end').datepicker();
        $("#datetimepicker_start").datepicker().on('changeDate', function(e) {
            $("#datetimepicker_end").datepicker('setStartDate', e.date);
        });
        $("#datetimepicker_end").datepicker().on('changeDate', function(e) {
            $("#datetimepicker_start").datepicker('setEndDate', e.date);
        });
    });
</script>