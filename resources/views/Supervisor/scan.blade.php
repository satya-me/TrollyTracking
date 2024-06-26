<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@200;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: rgb(255, 255, 255);
        }

        .container {
            max-width: 500px;
            text-align: center;
        }

        .container h1 {
            color: #ffffff;
        }

        .section {
            background-color: #ffffff;
            padding: 50px 30px;
            border: 1.5px solid #b2b2b2;
            border-radius: 0.25em;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.25);
        }

        #my-qr-reader {
            padding: 20px;
            border: 1.5px solid #b2b2b2;
            border-radius: 8px;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            border: 1px solid #b2b2b2;
            outline: none;
            border-radius: 0.25em;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 15px;
            background-color: #008000ad;
            transition: 0.3s background-color;
        }

        button:hover {
            background-color: #008000;
        }

        .scan-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .header-cell,
        .data-cell {
            padding: 8px;
            border: 1px solid #ccc;
        }

        .header-cell {
            font-weight: bold;
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="container mt-5">
            <h1>Scan QR Codes</h1>
            <div class="section">
                <div id="my-qr-reader"></div>
                <code id="resp"></code>
                <button id="rescanBtn" style="display: none;">Rescan</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let scanner = null;

            function onScanSuccess(qrCodeMessage) {
                playBeepSound();
                showScanResult(qrCodeMessage);
                scanner.clear();
                $('#rescanBtn').show();
            }

            function playBeepSound() {
                const beep = new Audio("{{ asset('assets/beep.mp3') }}");
                beep.play();
            }

            async function showScanResult(qrCodeMessage) { // Make this function async
                const respElement = $('#resp');

                try {
                    const parsedData = JSON.parse(qrCodeMessage);

                    if (typeof parsedData === 'object' && 'id' in parsedData && 'grade_name' in parsedData) {

                        const table = $('<table class="scan-table"></table>');
                        const headerRow = $('<tr></tr>');
                        headerRow.append('<th class="header-cell">Key</th>');
                        headerRow.append('<th class="header-cell">Value</th>');
                        table.append(headerRow);

                        $.each(parsedData, function(key, value) {
                            // List of keys to exclude
                            const excludeKeys = ['id', 'dispatch_status', 'origin',
                                'net_weight', 'gross_weight'
                            ];

                            // Check if the current key is in the excludeKeys array
                            if (!excludeKeys.includes(key)) {
                                const row = $('<tr></tr>');
                                row.append('<td class="data-cell">' + key + '</td>');
                                row.append('<td class="data-cell">' + value + '</td>');
                                table.append(row);
                            }
                        });

                        respElement.empty().append(table);
                        try {
                            const resp = await store(parsedData); // Now you can use await here
                            if (resp.success) {
                                // alert(resp.flag);
                                Swal.fire(resp.flag);
                            } else {
                                // alert(resp.flag);
                                Swal.fire(resp.flag);
                            }
                            console.log({
                                SRV: resp
                            });
                        } catch (error) {
                            Swal.fire('Error in function:', error);
                            console.error('Error in store function:', error);
                        }
                    } else {
                        throw new Error('Invalid format');
                    }
                } catch (error) {
                    Swal.fire("Invalid QR Code");
                    respElement.html('<div class="alert alert-danger">Invalid QR Code</div>');
                }
            }

            function initScanner() {
                scanner = new Html5QrcodeScanner("my-qr-reader", {
                    fps: 10,
                    qrbox: 250
                }, false);
                scanner.render(onScanSuccess);
            }

            $('#rescanBtn').click(function() {
                $('#resp').empty();
                $(this).hide();
                initScanner();
            });

            initScanner();
        });

        async function store(params) {
            console.log(params);
            console.log(typeof params);

            if (typeof params === 'string') {
                try {
                    params = JSON.parse(params);
                } catch (e) {
                    console.error('Invalid JSON string:', e);
                    return;
                }
            }

            return new Promise((resolve, reject) => {
                params.supervisor_id = "{{ Auth::user()->id }}";
                $.ajax({
                    url: "{{ route('supervisor.dispatch-status') }}",
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(params),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Response:', response);
                        console.log(typeof response);
                        if (response.success) {
                            resolve(response);
                        } else {
                            reject(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        reject('An error occurred while toggling the AC state.');
                    }
                });
            });
        }
    </script>

</body>

</html>
