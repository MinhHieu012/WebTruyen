<div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Card Actions</h2>
                <div class="breadcrumb-wrapper">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Card Actions
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
        <div class="mb-1 breadcrumb-right">
            <div class="dropdown">
                <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="grid"></i></button>
                <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="app-todo.html"><i class="me-1" data-feather="check-square"></i><span class="align-middle">Todo</span></a><a class="dropdown-item" href="app-chat.html"><i class="me-1" data-feather="message-square"></i><span class="align-middle">Chat</span></a><a class="dropdown-item" href="app-email.html"><i class="me-1" data-feather="mail"></i><span class="align-middle">Email</span></a><a class="dropdown-item" href="app-calendar.html"><i class="me-1" data-feather="calendar"></i><span class="align-middle">Calendar</span></a></div>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <section id="card-actions">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Card Actions</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                </li>
                                <li>
                                    <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                </li>
                                <li>
                                    <a data-action="close"><i data-feather="x"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Icon</th>
                                                    <th>Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Collapse</td>
                                                    <td class="text-center">
                                                        <i data-feather="chevron-down"></i>
                                                    </td>
                                                    <td>Collapse card content using collapse action.</td>
                                                </tr>
                                                <tr>
                                                    <td>Refresh Content</td>
                                                    <td class="text-center">
                                                        <i data-feather="rotate-cw"></i>
                                                    </td>
                                                    <td>Refresh your card content using refresh action.</td>
                                                </tr>
                                                <tr>
                                                    <td>Remove Card</td>
                                                    <td class="text-center">
                                                        <i data-feather="x"></i>
                                                    </td>
                                                    <td>Remove card from page using remove card action</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Info table about actions -->

        <!-- Collapsible and Refresh Actions -->
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Collapsible</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <p class="card-text">
                                You can create a collapsible content by by adding <code>[data-action="collapse"]</code> and wrapping it up
                                with <code>.heading-elements</code> in <code>.card-header</code>
                            </p>
                            <p class="card-text">
                                Click on<i data-feather="chevron-down" class="mx-50"></i>to see card collapse in action
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Refresh Content</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p class="card-text">
                                To create a card with refresh action use <code>[data-action="reload"]</code> inside of
                                <code>.heading-element</code>
                            </p>
                            <p class="card-text">
                                Click on<i data-feather="rotate-cw" class="mx-50"></i>icon to see refresh card content in action.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Collapsible and Refresh Actions -->

        <!-- Remove Action -->
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Remove Card</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <a data-action="close"><i data-feather="x"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <p class="card-text">
                                You can create a closeable card by using <code>[data-action="close"]</code> inside
                                <code>.heading-element</code>
                            </p>
                            <p class="card-text">Click on<i data-feather="x" class="mx-50"></i>icon to see closeable card in action.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Remove Action -->
    </section>
    <!--/ Card Actions Section -->

</div>