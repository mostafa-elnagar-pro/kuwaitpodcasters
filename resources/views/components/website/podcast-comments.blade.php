@props(['podcast', 'user_comment'])


<div id="comments_section" class="py-5">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <h4 class="mb-0 me-2">{{ __kw('comments', 'التعليقات') }}</h4>
                <span v-if="commentCount > 0" class="badge bg-primary rounded-pill fs-6" v-text="commentCount"></span>
            </div>


            <div class="form-group d-flex align-items-center gap-2">
                <label for="sort" class="h6 form-label">{{ __kw('sort_by', 'ترتيب حسب') }}</label>
                <select class="px-4 form-control form-control-sm" style="width:fit-content;cursor: pointer;"
                    @change="sortComments" v-model="sortBy">
                    <option value="latest">{{ __kw('latest', 'الاحدث') }}</option>
                    <option value="oldest">{{ __kw('oldest', 'الاقدم') }}</option>
                </select>
            </div>
        </div>

        <hr />

        <div v-if="userComment && !isEditing" class="review-card d-flex justify-content-between">
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-1">
                        <img :src="showProfileImg(userComment.user ? userComment.user.profile_img : '')"
                            class="rounded-circle" alt="user avatar" width="45" height="45">
                        <div>
                            <h6 class="mb-0" v-text="userComment ? userComment.user.name : ''"></h6>
                            <small class="text-muted" v-text="userComment.created_at"></small>
                        </div>
                    </div>
                </div>
                <p class="mt-3 fs-6" v-text="userComment.comment"></p>
            </div>

            <div class="d-flex gap-2 align-self-start">
                <button class="btn btn-sm btn-outline-primary" @click="isEditing = !isEditing">
                    {{ __kw('edit', 'تعديل') }}
                </button>
                <button class="btn btn-sm btn-outline-danger" @click="deleteComment">
                    {{ __kw('delete', 'حذف') }}
                </button>
            </div>
        </div>

        <form v-if="!userComment || isEditing" @submit.prevent="submitForm" class="my-4">
            <textarea class="form-control" name="comment" rows="3"
                placeholder="{{ __kw('write_comment', 'اكتب تعليقك هنا') }}" required minlength="2" v-model="commentInputValue"></textarea>

            <button v-if="!isEditing" type="submit"
                class="btn btn-primary mt-2">{{ __kw('add_comment', 'اضافة تعليق') }}</button>

            <div v-else class="mt-2 d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary">{{ __kw('save', 'حفظ') }}</button>
                <button type="button" class="btn btn-outline-secondary"
                    @click="isEditing = !isEditing">{{ __kw('cancel', 'الغاء') }}</button>
            </div>
        </form>

        <div v-show="isLoadingComments" id="loading" class="my-3">
            <div class="loader"></div>
        </div>

        <div v-for="comment in comments" :key="comment.id" class="review-card">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-1">
                    <img :src="showProfileImg(comment.user ? comment.user.profile_img : '')" class="rounded-circle"
                        alt="user avatar" width="45" height="45">
                    <div>
                        <h6 class="mb-0" v-text="comment.user ? comment.user.name : '[Deleted User]'"></h6>
                        <small class="text-muted" v-text="comment.created_at"></small>
                    </div>
                </div>
            </div>
            <p class="mt-3 fs-6" v-text="comment.comment"></p>
        </div>

        <div v-if="isLoadMoreVisible && !isLoadingComments" class="text-center mt-3">
            <a href="javascript:void(0)" @click="loadMoreComments"
                class="text-primary load-more">{{ __kw('load_more', 'اظهار المزيد') }}</a>
        </div>
    </div>
</div>





@push('js')
    <script src="{{ asset('assets/js/vue2.min.js') }}"></script>

    <script>
        new Vue({
            el: '#comments_section',
            data: {
                commentCount: "{{ $podcast->comments_count }}",
                isEditing: false,
                isLoadingComments: false,
                isLoadMoreVisible: true,
                currentPage: 1,
                sortBy: 'latest',
                userComment: @json($user_comment),
                comments: [],
                podcastId: "{{ $podcast->id }}",
                commentInputValue: this.userComment?.comment || '',
            },
            mounted() {
                this.fetchComments();
            },
            methods: {
                showProfileImg(path) {
                    return path || '/assets/images/default-user.svg'
                },
                async fetchComments() {
                    this.isLoadingComments = true;
                    fetch(`/podcasts/${this.podcastId}/comments?page=${this.currentPage}&sort=${this.sortBy}`, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.last_page === this.currentPage) {
                                this.isLoadMoreVisible = false
                            }
                            this.comments = [...this.comments, ...data.data];
                        })
                        .catch(error => {
                            console.error("ERROR FETCHING COMMENTS");
                        }).finally(() => {
                            this.isLoadingComments = false;
                        });
                },
                loadMoreComments() {
                    this.currentPage++;
                    this.fetchComments();
                },
                sortComments() {
                    this.currentPage = 1;
                    this.comments = [];
                    this.fetchComments();
                },
                submitForm() {
                    if (this.isEditing) {
                        this.editComment();
                        this.isEditing = false;
                    } else {
                        this.addComment();
                    }
                },
                addComment() {
                    fetch(`/podcasts/${this.podcastId}/comments`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                comment: this.commentInputValue,
                                _token: '{{ csrf_token() }}'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.userComment = data.data;
                            this.commentCount++;
                        })
                        .catch(error => {
                            console.error("ERROR ADDING COMMENT");
                        });
                },
                editComment() {
                    fetch(`/podcasts/${this.podcastId}/comments/${this.userComment.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                comment: this.commentInputValue,
                                _token: '{{ csrf_token() }}'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.userComment = data.data
                        })
                        .catch(error => {
                            console.error("ERROR EDITING COMMENT");
                        });
                },
                deleteComment() {
                    fetch(`/podcasts/${this.podcastId}/comments/${this.userComment.id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                _token: '{{ csrf_token() }}'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.commentInputValue = ''
                            this.userComment = null;
                            this.commentCount--;
                        })
                        .catch(error => {
                            console.error("ERROR DELETING COMMENT");
                        });
                },
            }
        })
    </script>
@endpush



@push('css')
    <style>
        #comments_section {
            background: #f9f9f9a9;
            position: relative;
        }

        .review-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .load-more:hover {
            text-decoration: underline;
            cursor: pointer;
        }

        #loading {
            position: absolute;
            bottom: 5%;
            left: 50%;
        }
    </style>
@endpush
