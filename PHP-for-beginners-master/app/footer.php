    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/public/js/bootstrap.min.js"></script>
    <script>
        function getUrlParameter(url, parameter) {
            parameter = parameter.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
            var regex = new RegExp('[\\?|&]' + parameter.toLowerCase() + '=([^&#]*)');
            var results = regex.exec('?' + url.toLowerCase().split('?')[1]);
            return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
        }

        function setUrlParameter(url, key, value) {

            var baseUrl = url.split('?')[0],
                urlQueryString = '?' + url.split('?')[1],
                newParam = key + '=' + value,
                params = '?' + newParam;

            // If the "search" string exists, then build params from it
            if (urlQueryString) {
                var updateRegex = new RegExp('([\?&])' + key + '[^&]*');
                var removeRegex = new RegExp('([\?&])' + key + '=[^&;]+[&;]?');

                if (typeof value === 'undefined' || value === null || value === '') { // Remove param if value is empty
                    params = urlQueryString.replace(removeRegex, "$1");
                    params = params.replace(/[&;]$/, "");

                } else if (urlQueryString.match(updateRegex) !== null) { // If param exists already, update it
                    params = urlQueryString.replace(updateRegex, "$1" + newParam);

                } else { // Otherwise, add it to end of query string
                    params = urlQueryString + '&' + newParam;
                }
            }

            // no parameter was set so we don't need the question mark
            params = params === '?' ? '' : params;

            return baseUrl + params;
        }

        var pageSelect = document.getElementById('page-select');
        var currentPage = getUrlParameter(window.location.href, 'page');

        if (currentPage) {
            pageSelect.value = currentPage;
        }

        pageSelect.addEventListener('change', function (event) {
            var value = event.target.value;

            window.location.href = setUrlParameter(window.location.href, 'page', value);
        });
    </script>
</body>
</html>

