<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th data-sort="date">Date</th>
            <th data-sort="category_id">Category</th>
            <th data-sort="client_id">Client</th>
            <th data-sort="label_id">Label</th>
            <th data-sort="value">Value</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        $total = 0;
        foreach($stats as $row) { 
            $total += $row->value;
            ?>
            <tr><td>{{ $row->date }}</td><td>{{ $row->category_id }}</td><td>{{ $row->client_id }}</td><td>{{ $row->label_id }}</td><td>{{ $row->value }}</td></tr>
    <?php } ?>
        <tr><td><strong>Total</strong></td><td></td><td></td><td></td><td><strong>{{ $total }}</strong></td></tr>
    </tbody>
</table>

<script>
    $( document ).ready(function() {
        $('th').each(function(i, el) {
            $(el).click(function() {
                table_ajax($(el).data('sort'));
            });
            $(el).css( 'cursor', 'pointer' );
        });
    });
</script>