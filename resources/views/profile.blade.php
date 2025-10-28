@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="chart-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0"><i class="fas fa-user-cog me-2"></i>Profile Settings</h4>
                <span class="badge bg-primary">Active</span>
            </div>

            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="mb-4">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center"
                             style="width: 100px; height: 100px;">
                            <i class="fas fa-user fa-3x text-white"></i>
                        </div>
                    </div>
                    <h5>{{ Auth::user()->name }}</h5>
                    <p class="text-muted">{{ Auth::user()->email }}</p>
                    <div class="mt-3">
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Verified
                        </span>
                    </div>
                </div>

                <div class="col-md-8">
                    <form>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label class="form-label fw-bold">Full Name</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label class="form-label fw-bold">Email Address</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label class="form-label fw-bold">Member Since</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ Auth::user()->created_at->format('F d, Y') }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label class="form-label fw-bold">Account Type</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="Premium User" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label class="form-label fw-bold">Last Login</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::now()->subHours(2)->format('M d, Y H:i') }}" readonly>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <div class="d-flex">
                                <i class="fas fa-info-circle me-2 mt-1"></i>
                                <div>
                                    <small>
                                        To update your profile information, please contact the administrator or
                                        <a href="#" class="alert-link">upgrade your account</a> to access advanced settings.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Profile Stats -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="info-card text-center">
            <i class="fas fa-calendar-check fa-2x text-primary mb-2"></i>
            <h5>12</h5>
            <p class="text-muted mb-0">Projects</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-card text-center">
            <i class="fas fa-tasks fa-2x text-success mb-2"></i>
            <h5>48</h5>
            <p class="text-muted mb-0">Tasks Completed</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-card text-center">
            <i class="fas fa-award fa-2x text-warning mb-2"></i>
            <h5>5</h5>
            <p class="text-muted mb-0">Achievements</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-card text-center">
            <i class="fas fa-clock fa-2x text-info mb-2"></i>
            <h5>256</h5>
            <p class="text-muted mb-0">Hours Logged</p>
        </div>
    </div>
</div>
@endsection
