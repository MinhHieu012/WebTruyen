$(document).ready(function () {
    const searchStory = $('.search-story')
    if (searchStory) {
        searchStory.on('keyup', function (e) {
            // console.log($(this).val());
            const searchResult = $('.search-result')
            const list = searchResult.find('.list-group')

            if ($(this).val().length == 0) {
                if (searchResult) {
                    searchResult.addClass('d-none')
                    searchResult.addClass('no-result')
                    list.addClass('d-none')
                }
            } else {
                // if ($(this).val().length > 2) {
                fetch(route('search.story'), {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.SuuTruyen.csrfToken,
                    },
                    body: JSON.stringify({
                        key_word: $(this).val()
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        // console.log(data);
                        if (data.success) {
                            let html = ''
                            if (searchResult) {
                                searchResult.removeClass('d-none')
                                list.empty()
    
                                searchResult.removeClass('no-result')
                                list.removeClass('d-none')

                                if (data.stories.length > 0 && list) {
                                    data.stories.forEach(story => {
                                        html += `
                                                <li class="list-group-item">
                                                    <a href="${route('story', story.slug)}" class="text-dark hover-title">${story.name}</a>
                                                </li>
                                            `
                                    });
                                } else {
                                    html += `
                                    <li class="list-group-item border-0">
                                    Không tìm thấy truyện nào 
                                    </li>
                                    `
                                }
                                list.html(html);
                            }
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                        if (error.status !== 500) {
                            let errorMessages = error.responseJSON.errors;
                        } else {
                            errorContent = error.responseJSON.message;
                        }
                    })
                // }
            }
        })
    }
})