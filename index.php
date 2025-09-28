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
            font-size: 0.875rem;re
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

    <!-- Showing X to Y of Z entries (aligned to the left) -->
    <div id="data-info" class="text-sm text-gray-700 mb-4 pagination-info">
        Showing 1 to 10 of 100 entries
    </div>

    <!-- Loading Spinner -->
    <div id="loading-spinner" class="flex justify-center items-center mb-4" style="display: none;">
        <div class="loading-spinner"></div>
    </div>

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
    <div style="background:#f5f5f5; padding:10px; text-align:center;">
    <a href="host-summary.php" style="
        padding: 8px 16px;
        background: #007BFF;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
    ">
        📊 View Data Written Per Host
    </a>
</div>
</div>

<script>
$(document).ready(function() {
    // Function to load data
    function loadData(page, limit) {
        // Show loading spinner
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

    // Function to update the table and pagination controls
    function updateTable(data) {
        let tableHead = $('#data-table thead');
        let tableBody = $('#data-table tbody');
        let paginationControls = $('#pagination-controls');
        let dataInfo = $('#data-info');

        // Clear the table head and body
        tableHead.empty();
        tableBody.empty();

        // Populate the table headers dynamically based on the column names
        let headerRow = '<tr class="bg-gradient-to-r from-purple-500 to-indigo-500 text-white text-left font-semibold">';
        data.columns.forEach(function(column) {
            headerRow += '<th class="p-3">' + column + '</th>';
        });
        headerRow += '</tr>';
        tableHead.append(headerRow);

        // Populate the table rows
        data.data.forEach(function(row) {
            let rowHtml = '<tr>';
            row.forEach(function(cell) {
                rowHtml += '<td class="p-3 text-gray-900">' + cell + '</td>';
            });
            rowHtml += '</tr>';
            tableBody.append(rowHtml);
        });

        // Calculate start and end correctly
        let start = (data.page - 1) * data.limit + 1;
        let end = Math.min(data.page * data.limit, data.totalRows); // Ensure `end` is not greater than `totalRows`
        
        // If data.limit is 0 or undefined, make sure to set a valid value for end.
        if (!data.limit) {
            data.limit = 10;  // Default to 10 if limit is not provided
            start = 1;
            end = Math.min(data.limit, data.totalRows);
        }

        // Update data info text
        dataInfo.text('Showing ' + start + ' to ' + end + ' of ' + data.totalRows + ' entries');

        // Update pagination controls (limit to a smaller range of pages)
        let paginationHtml = '';
        let pageRange = 15; // Number of page links to show at a time
        let startPage = Math.max(1, data.page - Math.floor(pageRange / 2));
        let endPage = Math.min(data.totalPages, startPage + pageRange - 1);

        if (data.page > 1) {
            paginationHtml += '<a href="javascript:void(0);" class="page-link px-4 py-2 bg-indigo-500 text-white rounded-lg" data-page="' + (data.page - 1) + '">Previous</a>';
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationHtml += '<a href="javascript:void(0);" class="page-link px-4 py-2 bg-indigo-500 text-white rounded-lg ' + (i === data.page ? 'bg-indigo-700' : '') + '" data-page="' + i + '">' + i + '</a>';
        }

        if (data.page < data.totalPages) {
            paginationHtml += '<a href="javascript:void(0);" class="page-link px-4 py-2 bg-indigo-500 text-white rounded-lg" data-page="' + (data.page + 1) + '">Next</a>';
        }

        paginationControls.html(paginationHtml);
    }

    // Handle page change
    $(document).on('click', '.page-link', function() {
        var page = $(this).data('page');
        var limit = $('#limit').val();
        loadData(page, limit);
    });

    // Handle records per page change
    $('#limit').change(function() {
        var limit = $(this).val();
        loadData(1, limit); // Reset to page 1 when limit changes
    });

    // Initial data load
    loadData(1, 25); // Load page 1 with default limit 25
});
</script>
</body>
</html>
