$(document).ready(function () {
    if (route().current('story')) {
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };

        var page = getUrlParameter('page');

        // if (page) {
        //     $('html, body').animate({
        //         scrollTop: $('.story-detail__list-chapter').offset().top
        //     }, 500);
        // }

        const storySlug = $("#story_slug").val()
        const inputNumberPaginate = $('.choose-paginate .input-paginate')
        inputNumberPaginate.val(page ? page : 1)

        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('input-paginate')) {
                e.target.setAttribute('value', e.target.value)
            }
        })

        function renderListChapter(pageValue, data) {
            const parser = new DOMParser();
            const html = parser.parseFromString(data, 'text/html');
            const chaptersList = html.querySelector('.story-detail__list-chapter--list');

            const chapterListOld = document.querySelector('.story-detail__list-chapter--list')
            if (chaptersList && chapterListOld) {
                chapterListOld.replaceWith(chaptersList)
            }

            const pagination = html.querySelector('.pagination')
            const paginationOld = document.querySelector('.pagination')
            if (pagination && paginationOld) {
                const inputPaginateNew = pagination.querySelector('.input-paginate')
                if (inputPaginateNew) {
                    inputPaginateNew.setAttribute('value', pageValue);
                }
                paginationOld.replaceWith(pagination)
            }

            var newUrl = route('story', storySlug) + `?page=${pageValue}`;
            var newState = { page: "new-page" };
            history.pushState(newState, null, newUrl);
        }

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-go-paginate')) {
                const inputPaginate = $(".input-paginate")
                window.loadingFullPage()

                fetch(route('story', storySlug) + `?page=${inputPaginate.val()}`)
                    .then(res => res.text())
                    .then(data => {
                        renderListChapter(inputPaginate.val(), data)
                        window.loadingFullPage()
                    })
                    .catch(function (error) {
                        console.log(error);
                        if (error.status !== 500) {
                            let errorMessages = error.responseJSON.errors;
                        } else {

                        }
                    })
            }

            if (e.target.classList.contains('story-ajax-paginate')) {
                let dataUrl = e.target.getAttribute('data-url');
                let urlParams = new URLSearchParams(dataUrl.split('?')[1]);
                let pageValue = urlParams.get("page");

                window.loadingFullPage()

                fetch(route('story', storySlug) + `?page=${pageValue}`)
                    .then(res => res.text())
                    .then(data => {
                        renderListChapter(pageValue, data)

                        window.loadingFullPage()
                    })
                    .catch(function (error) {
                        console.log(error);
                        if (error.status !== 500) {
                            let errorMessages = error.responseJSON.errors;
                        } else {

                        }
                    })
            }
        })

        // const choosePaginate = $('.choose-paginate')

        // if (choosePaginate) {
        //     const storySlug = $("#story_slug").val()
        //     const inputNumberPaginate = $('.choose-paginate .input-paginate')

        //     inputNumberPaginate.val(page ? page : 1)

        //     const btnGoPaginate = $('.choose-paginate .btn-go-paginate')
        //     btnGoPaginate.on('click', function (e) {
        //         fetch(route('story', storySlug) + `?page=${inputNumberPaginate.val()}`)
        //             .then(res => res.text())
        //             .then(data => {
        //                 const parser = new DOMParser();
        //                 const html = parser.parseFromString(data, 'text/html');
        //                 const chaptersList = html.querySelector('.story-detail__list-chapter--list');
        //                 console.log(chaptersList);

        //                 const chapterListOld = document.querySelector('.story-detail__list-chapter--list')
        //                 if (chaptersList && chapterListOld) {
        //                     chapterListOld.replaceWith(chaptersList)
        //                 }

        //                 const pagination = html.querySelector('.pagination')
        //                 const paginationOld = document.querySelector('.pagination')
        //                 if (pagination && paginationOld) {
        //                     const inputPaginate = pagination.querySelector('.input-paginate')
        //                     if (inputPaginate) {
        //                         inputPaginate.setAttribute('value', inputNumberPaginate.val());
        //                     }
        //                     paginationOld.replaceWith(pagination)
        //                 }
        //             })
        //             .catch(function (error) {
        //                 console.log(error);
        //                 if (error.status !== 500) {
        //                     let errorMessages = error.responseJSON.errors;
        //                 } else {

        //                 }
        //             })
        //         // window.location.href = route('story', storySlug) + `?page=${inputNumberPaginate.val()}`
        //     })
        // }
    }

})