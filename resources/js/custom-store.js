function isNotEmpty(value)
{
    return value !== undefined && value !== null && value !== "";
}

function prettyErrors(d, message, error)
{
    if (error.status === 422) {
        const errors = error.responseJSON.errors;
        const errorMessage = errors.reduce((pre, curr) => pre + '<br>' + curr, error.responseJSON.message);

        DevExpress.ui.dialog.alert(errorMessage, 'Uyarı');
    }

    return d.reject(message);
}

function prettyErrorsSimple(error)
{
    if (error.status === 422) {
        const errors = error.responseJSON.errors;

        const errorMessage = Object.values(errors).reduce(function(pre, curr) {
            return pre + '<br>' + curr;
        }, error.responseJSON.message);

        DevExpress.ui.dialog.alert(errorMessage, 'Uyarı');
    }
}

function createCustomStoreOptions(key, urls)
{
    const customStoreOptions = {
        key: key,
        load: function (loadOptions) {
            const d = $.Deferred();
            const params = {};
            [
                'filter',
                'group',
                'groupSummary',
                'parentIds',
                'requireGroupCount',
                'requireTotalCount',
                'searchExpr',
                'searchOperation',
                'searchValue',
                'select',
                'sort',
                'skip',
                'take',
                'totalSummary',
                'userData'
            ].forEach(function (i) {
                if (i in loadOptions && isNotEmpty(loadOptions[i])) {
                    params[i] = JSON.stringify(loadOptions[i]);
                }
            });

            $.ajax({
                url: urls.load,
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: params,
                success: function (response) {
                    d.resolve(response.data, {
                        totalCount: response.totalCount,
                        summary: response.summary,
                    });
                },
                error: function (error) {
                    throw prettyErrors(d, 'Veri sorgulanamadı.', error);
                }
            });

            /*$.getJSON(urls.load, params)
                .done(function (response) {
                    d.resolve(response.data, {
                        totalCount: response.totalCount,
                        summary: response.summary,
                    });
                })
                .fail(function () {
                    throw 'Data loading error'
                });*/

            return d.promise();
        },
        errorHandler: function (error) {
            console.log('errorHandler', error);
        }
    };

    if (urls.insert) {
        customStoreOptions.insert = function (values) {
            const d = $.Deferred();

            $.ajax({
                url: urls.insert,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: values,
                success: function (response) {
                    d.resolve(response);
                },
                error: function (error) {
                    return prettyErrors(d, 'Kayıt yapılamadı', error);
                }
            });

            return d.promise();
        };
    }

    if (urls.update) {
        customStoreOptions.update = function (key, values) {
            const d = $.Deferred();

            $.ajax({
                url: urls.update,
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    key: key,
                    ...values
                },
                success: function (response) {
                    d.resolve(response);
                },
                error: function (error) {
                    return prettyErrors(d, 'Kayıt güncellenemedi.', error);
                }
            });

            return d.promise();
        };
    }

    if (urls.remove) {
        customStoreOptions.remove = function (key) {
            const d = $.Deferred();

            $.ajax({
                url: urls.remove,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    key: key
                },
                success: function (response) {
                    d.resolve(response);
                },
                error: function (error) {
                    return prettyErrors(d, 'Kayıt silinemedi.', error);
                }
            });

            return d.promise();
        };
    }

    return customStoreOptions;
}

