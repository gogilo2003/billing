<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="{{ route('home') }}" class="simple-text logo-mini"><img src="{{ asset('favicon.png') }}"></a>
            <a href="{{ route('home') }}" class="simple-text logo-normal">{{ _('BILLING') }}</a>
        </div>
        <ul class="nav">

            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ _('Dashboard') }}</p>
                </a>
            </li>

            <li>
                <a data-toggle="collapse" href="#navbar-clients" aria-expanded="false">
                    <i class="fas fa-users" ></i>
                    <span class="nav-link-text" >{{ __('Clients') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="navbar-clients">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'clients') class="active " @endif>
                            <a href="{{ route('clients')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ _('List') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'clients/create') class="active " @endif>
                            <a href="{{ route('clients-create')  }}">
                                <i class="tim-icons icon-simple-add"></i>
                                <p>{{ _('New') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" href="#navbar-accounts" aria-expanded="false">
                    <i class="tim-icons icon-bank" ></i>
                    <span class="nav-link-text" >{{ __('Accounts') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="navbar-accounts">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'accounts') class="active " @endif>
                            <a href="{{ route('accounts')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ _('List') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'accounts/create') class="active " @endif>
                            <a href="{{ route('accounts-create')  }}">
                                <i class="tim-icons icon-simple-add"></i>
                                <p>{{ _('New') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" href="#navbar-invoices" aria-expanded="false">
                    <i class="tim-icons icon-paper" ></i>
                    <span class="nav-link-text" >{{ __('Invoices') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="navbar-invoices">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'invoices') class="active " @endif>
                            <a href="{{ route('invoices')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ _('List') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'invoices/create') class="active " @endif>
                            <a href="{{ route('invoices-create')  }}">
                                <i class="tim-icons icon-simple-add"></i>
                                <p>{{ _('New') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a data-toggle="collapse" href="#navbar-messages" aria-expanded="false">
                    <i class="tim-icons icon-chat-33" ></i>
                    <span class="nav-link-text" >{{ __('Messages') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="navbar-messages">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'messages') class="active " @endif>
                            <a href="{{ route('messages')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ _('List') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'messages/create') class="active " @endif>
                            <a href="{{ route('messages-create')  }}">
                                <i class="tim-icons icon-email-85"></i>
                                <p>{{ _('Create Message') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li @if ($pageSlug == 'domains') class="active " @endif>
                <a href="{{ route('domains') }}">
                    <i class="tim-icons icon-world"></i>
                    <p>{{ _('Domains') }}</p>
                </a>
            </li>

            <li @if ($pageSlug == 'setup') class="active " @endif>
                <a href="{{ route('setup') }}">
                    <i class="tim-icons icon-settings"></i>
                    <p>{{ _('Setup') }}</p>
                </a>
            </li>

        </ul>
    </div>
</div>
