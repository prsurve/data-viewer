<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Viewer</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Pagination and Info Styling */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: center;
        }

        .pagination-info {
            flex: 1;
            text-align: left;
            padding: 0.5rem;
            font-size: 0.875rem; /* ✅ removed stray "re" */
        }

        .pagination-controls {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .page-link {
            padding: 0.5rem 1rem;
            background-color: #4c51bf;
            color: white;
            border-radius: 0.375rem;
            text-decoration: none;
        }

        .page-link:hover {
            background-color: #434190;
        }

        .page-link.active {
            background-color: #2b2d72;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">

<div class="container mx-auto py-6 px-4">

    <!-- ✅ Button for Host Summary at the Top -->
    <div class="flex justify-center mb-4">
        <a href="host-summary.php" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">
            📊 View Data Written Per Host
        </a>
    </div>

    <!-- Dropdown for Record Limit -->
    <div class="flex justify-end mb-4">
        <label for="limit" class="mr-2 text-sm font-semibold text-gray-700">Records per Page:</label>
        <select id="limit" name="limit" class="border border-gray-300 rounded-lg p-2 text-gray-700">
            <option value="25" selected>25</option>
            <option value="50">50</option>
            <option value="250">250</option>
            <option value="500">500</option>
        </select>
    </div>

    <!-- Showing X to Y of Z entries -->
    <div id="data-info" class="text-sm text-gray-700 mb-4 pagination-info">
        Showing 1 to 10 of 100 entries
    </div>

    <!-- Loading Spinner -->
    <div id="loading-spinner" class="flex justify-center items-center mb-4" style="display: none;">
        <div class="loading-spinner"></div>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 text-sm" id="data-table">
            <thead>
                <tr class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white text-left font-semibold">
                    <!-- Table headers will be dynamically populated -->
                </tr>
            </thead>
            <tbody>
                <!-- Data will be populated via AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <div id="pagination-controls" class="pagination-container mt-4">
        <!-- Pagination will be populated via AJAX -->
    </div>

</div>

<script>
$(document).ready(function() {
    function loadData(page, limit) {
        $('#loading-spinner').show();
        $.ajax({
            url: 'load-data.php',
            type: 'GET',
            data: { page: page, limit: limit },
            success: function(response) {
                let data = JSON.parse(response);
                updateTable(data);
            },
            error: function() {
                alert("An error occurred while loading the data.");
            },
            complete: function() {
                $('#loading-spinner').hide();
            }
        });
    }

    function updateTable(data) {
        let tableHead = $('#data-table thead');
        let tableBody = $('#data-table tbody');
        let paginationControls = $('#pagination-controls');
        let dataInfo = $('#data-info');

        tableHead.empty();
        tableBody.empty();

        let headerRow = '<tr class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white text-left font-semibold">';
        data.columns.forEach(function(column) {
            headerRow += '<th class="p-3">' + column + '</th>';
        });
        headerRow += '</tr>';
        tableHead.append(headerRow);

        data.data.forEach(function(row) {
            let rowHtml = '<tr>';
            row.forEach(function(cell) {
                rowHtml += '<td class="p-3 text-gray-900">' + cell + '</td>';
            });
            rowHtml += '</tr>';
            tableBody.append(rowHtml);
        });

        let start = (data.page - 1) * data.limit + 1;
        let end = Math.min(data.page * data.limit, data.totalRows);

        if (!data.limit) {
            data.limit = 10;
            start = 1;
            end = Math.min(data.limit, data.totalRows);
        }

        dataInfo.text('Showing ' + start + ' to ' + end + ' of ' + data.totalRows + ' entries');

        let paginationHtml = '';
        let pageRange = 15;
        let startPage = Math.max(1, data.page - Math.floor(pageRange / 2));
        let endPage = Math.min(data.totalPages, startPage + pageRange - 1);

        if (data.page > 1) {
            paginationHtml += '<a href="javascript:void(0);" class="page-link" data-page="' + (data.page - 1) + '">Previous</a>';
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationHtml += '<a href="javascript:void(0);" class="page-link ' + (i === data.page ? 'active' : '') + '" data-page="' + i + '">' + i + '</a>';
        }

        if (data.page < data.totalPages) {
            paginationHtml += '<a href="javascript:void(0);" class="page-link" data-page="' + (data.page + 1) + '">Next</a>';
        }

        paginationControls.html(paginationHtml);
    }

    $(document).on('click', '.page-link', function() {
        var page = $(this).data('page');
        var limit = $('#limit').val();
        loadData(page, limit);
    });

    $('#limit').change(function() {
        var limit = $(this).val();
        loadData(1, limit);
    });

    loadData(1, 25);
});
</script>
</body>
</html>
