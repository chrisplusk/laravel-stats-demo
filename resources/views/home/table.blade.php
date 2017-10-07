<table class="table table-striped table-hover">
    <thead>
        <tr><th>Date</th><th>Category</th><th>Client</th><th>Label</th><th>Value</th></tr>
    </thead>
    <tbody>
    <?php foreach($stats as $row) { ?>
        <tr><td>{{ $row->date }}</td><td>{{ $row->category_id }}</td><td>{{ $row->client_id }}</td><td>{{ $row->label_id }}</td><td>{{ $row->value }}</td></tr>
    <?php } ?>
    </tbody>
</table>