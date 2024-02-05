<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Generation in Progress</title>
    <!-- Add any additional styles or scripts if needed -->
    <style>
        #loading-spinner {
            display: none;
        }

        #progress-bar-container {
            display: none;
            margin-top: 20px;
        }

        #progress-bar {
            width: 0;
            height: 20px;
            background-color: #4CAF50;
        }
    </style>
</head>
<body>
    <div style="text-align: center; padding: 50px;">
        <h2>PDF Generation in Progress</h2>
        <p id="pdf-status">{{ $success }}</p>
        <p id="pdf-url-message" style="display: none;">PDF is ready for download. Click <a id="pdf-download-link" href="#">here</a> to download.</p>

        <!-- Loading spinner -->
        <div id="loading-spinner">
            <img src="https://www.loading.io/spinners/double-ring/lg.double-ring-spinner.gif" alt="Loading Spinner">
        </div>

        <!-- Progress bar -->
        <div id="progress-bar-container">
            <div id="progress-bar"></div>
        </div>

        <!-- You can add more interactive elements or customize as needed -->
    </div>

    <!-- JavaScript to show/hide the loading spinner, display the download link, and update the progress bar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Show the loading spinner when the page loads
            document.getElementById('loading-spinner').style.display = 'block';

            // Start listening for progress events
            Echo.channel('pdf-progress.{{ $actionId }}')
                .listen('PdfGenerationProgress', (event) => {
                    if (event.progress === 100) {
                        // PDF generation is complete
                        document.getElementById('loading-spinner').style.display = 'none';
                        document.getElementById('pdf-url-message').style.display = 'block';

                        // Set the href attribute of the download link with the actual PDF URL
                        var pdfUrl = '/path/to/actual/pdf'; // Replace with the actual PDF URL
                        document.getElementById('pdf-download-link').href = pdfUrl;
                    } else {
                        // Update the progress bar
                        document.getElementById('progress-bar-container').style.display = 'block';
                        document.getElementById('progress-bar').style.width = event.progress + '%';
                    }
                });
        });
    </script>
</body>
</html>
