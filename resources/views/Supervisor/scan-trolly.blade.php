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

    <!-- Modal -->
    <div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scanModalLabel">Scan Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="scanForm">
                        <div class="mb-3">
                            {{-- <label for="place" class="form-label">Place</label> --}}
                            <label class="lable_style" for="place">Place</label>
                            {{-- <input type="text" class="form-control" id="place" name="place" required> --}}
                            <select class="form-select" name="place"  id="place">
                                <option value="">Select</option>
                                <option value="VILLAGE">VILLAGE</option>
                                <option value="RCN BOILING">RCN BOILING</option>
                                <option value="SCOOPING">SCOOPING</option>
                                <option value="BORMA/ DRYING(New)">BORMA/ DRYING(New)</option>
                                <option value="BORMA/ DRYING(Final)">BORMA/ DRYING(Final)</option>
                                <option value="PEELING">PEELING</option>
                                <option value="SMALL TAIHO">SMALL TAIHO</option>
                                <option value="MAYUR">MAYUR</option>
                                <option value="HAMSA">HAMSA</option>
                                <option value="WHOLES GRADING">WHOLES GRADING</option>
                                <option value="LW GRADING">LW GRADING</option>
                                <option value="SHORTING">SHORTING</option>
                                <option value="DP & DS GRADING">DP & DS GRADING</option>
                                <option value="PACKING">PACKING</option>
                                <option value="OUTSIDE VILLAGE">OUTSIDE VILLAGE</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <input type="hidden" id="trolly_name" name="trolly_name">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
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

            async function showScanResult(qrCodeMessage) {
                $('#trolly_name').val(qrCodeMessage);
                $('#scanModal').modal('show');
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

            $('#scanForm').submit(function(e) {
                e.preventDefault();
                const formData = {
                    supervisor: $('#name').val(),
                    supervisor_id: "{{ Auth::user()->id }}",
                    department: "{{ Auth::user()->department }}",
                    trolly_name: $('#trolly_name').val(),
                    place: $('#place').val(),
                    quantity: $('#quantity').val()
                };
                store(formData);
                $('#scanModal').modal('hide');
            });

            initScanner();
        });

        async function store(params) {
            try {
                const response = await $.ajax({
                    url: "{{ route('supervisor.trolly-status') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(params),
                    dataType: 'json',
                });
                console.log(response);
                // alart(response);

                if (response.status == 400) {
                    Swal.fire('Error', response.error, 'error');
                } else {
                    Swal.fire('Success', response.message, 'success');
                }

            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error', error, 'error');
            }
        }
    </script>
</body>

</html>
