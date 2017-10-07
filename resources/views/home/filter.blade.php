<form id="filter_form" action="home/apply" method="POST">

    {{ csrf_field() }}
    
    <div class="row">

        <div class="col-md-12">

                <div class='col-md-6'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker_start'>
                            <input name="start_date" type='text' class="form-control" value="{{ $selected_start_date }}" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker_end'>
                            <input name="end_date" type='text' class="form-control" value="{{ $selected_end_date }}" />
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

            <select name="client_id" style="width: 100%;">
              <?php foreach($clients as $client) { ?>
                    <option value="{{ $client->client_id }}" {{{ $client->client_id == $selected_client_id ? 'selected' : '' }}} >Client {{ $client->client_id }}</option>
                <?php } ?>
            </select>

        </div>
        <div class="col-md-3">

            <select name="categories[]" multiple style="width: 100%;">
              <?php foreach($categories as $category) { ?>
                    <option value="{{ $category->category_id }}" {{{ in_array($category->category_id, $selected_categories) ? 'selected' : '' }}} >Category {{ $category->category_id }}</option>
                <?php } ?>
            </select>

        </div>
        <div class="col-md-3">

            <select name="labels[]" multiple style="width: 100%;">
              <?php foreach($labels as $label) { ?>
                    <option value="{{ $label->label_id }}" {{{ in_array($label->label_id, $selected_labels) ? 'selected' : '' }}} >Label {{ $label->label_id }}</option>
                <?php } ?>
            </select>

        </div>
        <div class="col-md-3">

            <select name="value_equals">
                <option value="ltoe" {{{ 'ltoe' == $selected_value_equals ? 'selected' : '' }}} >Value &lt;=</option>
                <option value="gtoe" {{{ 'gtoe' == $selected_value_equals ? 'selected' : '' }}} >Value &gt;=</option>
            </select>

            <input name="value" value="{{ $selected_value }}" type="text" />

        </div>

    </div>

</form>

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