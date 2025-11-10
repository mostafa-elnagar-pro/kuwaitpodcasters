<script>
    function AxiosPost(url, data, callBackFunction) {
        axios.post(url, data)
            .then((response) => {
                callBackFunction(response)
            }).catch((error) => {
            callBackFunction(error.response)
        })
    }

    function AxiosUpdate(url, data) {
        axios.post(url, data)
            .then((response) => {
                toastr.success("{{__('app.success updated')}}");
            }).catch((error) => {
            toastr.error( error.message)
        })
    }

    function AxiosBulkDelete(url, data, callBackFunction) {

        axios.post(url, data)
            .then((response) => {
                callBackFunction(response)
            })
            .catch((error) => {
                callBackFunction(error)
            })
    }

    function AxiosDeleteItem(url, data, callBackFunction) {
        axios.delete(url, data)
            .then((response) => {
                callBackFunction(response)
            })
            .catch((error) => {
                callBackFunction(error)
            })
    }
</script>
