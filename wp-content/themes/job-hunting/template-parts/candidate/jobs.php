<?php

use EcJobHunting\Service\User\UserService;

$candidate = UserService::getUser(get_current_user_id());
$searchString = $_REQUEST['search_string'] ?? '';
$location = $_REQUEST['location'] ?? $candidate->getLocation();
?>
<form class="hero-form">
    <div class="container">
        <div class="row d-flex justify-content-xl-center">
            <div class="col-12 col-md-5 col-xl-4">
                <label class="my-2">
                    <input
                        class="field-text"
                        type="text"
                        name="search_string"
                        placeholder="Job Title"
                        value="<?php echo $searchString; ?>"
                    >
                </label>
            </div>
            <div class="col-12 col-md-5 col-xl-4">
                <label class="my-2">
                    <input
                        class="field-text js-auto-complete"
                        type="text"
                        name="location"
                        placeholder="Location"
                        value="<?php echo $location; ?>"
                        autocomplete="off"
                    >
                </label>
            </div>
            <div class="col-12 col-md-2">
                <button class="btn btn-primary my-2" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>
<section class="results">
    <div class="container">
        <div class="row">
            <div class="col-12" data-tab>
                <ul class="results-header">
                    <li class="d-md-none" data-tab-value><span>Suggested Jobs</span></li>
                    <li class="active" data-tab-item="suggested">Suggested Jobs</li>
                    <li data-tab-item="applied">Applied Jobs</li>
                    <li data-tab-item="saved">Saved Jobs</li>
                </ul>
                <div class="results-link">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <p>Below are other jobs you might like, based on your resume, prior job applications and search history.</p>
                            </div>
                            <div class="col-12 col-md-4 d-md-flex justify-content-md-end"><a class="color-primary" href="#">View Dismissed Jobs <i class="fa fa-angle-right"></i></a></div>
                        </div>
                    </div>
                </div>
                <ul class="results-content">
                    <li class="active" data-tab-content="suggested">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-7.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Front-End Developer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements : US Citizen, GC Holders or Authorized to Work in the US Overview: We are seeking a senior</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-8.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Sr. .NET Developer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-9.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Senior Ruby Developer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements : US Citizen, GC Holders or Authorized to Work in the US Overview: We are seeking a senior</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-10.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Senior Ruby Developer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements : US Citizen, GC Holders or Authorized to Work in the US Overview: We are seeking a senior</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-1.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Full Stack Software Engineer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements : US Citizen</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-2.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Full Stack Software Engineer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements : US Citizen, GC Holders or Authorized to Work in the US Overview: We are seeking a senior</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li data-tab-content="applied">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-9.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Senior Ruby Developer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements : US Citizen, GC Holders or Authorized to Work in the US Overview: We are seeking a senior</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-10.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Senior Ruby Developer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements : US Citizen, GC Holders or Authorized to Work in the US Overview: We are seeking a senior</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-1.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Full Stack Software Engineer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements : US Citizen</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-2.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Full Stack Software Engineer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements : US Citizen, GC Holders or Authorized to Work in the US Overview: We are seeking a senior</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li data-tab-content="saved">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-1.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Full Stack Software Engineer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements : US Citizen</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4 d-flex">
                                    <div class="card-vacancy">
                                        <div class="card-vacancy-logo"><img src="images/companies-image-2.png" alt="logo"></div>
                                        <div class="card-vacancy-content">
                                            <h3>Full Stack Software Engineer</h3><span>TekPartners, A P2P Company</span><span>Boynton Beach, FL</span>
                                            <ul>
                                                <li><span>Pay</span><span>xxx</span></li>
                                                <li><span>Benefits</span><span>xxx</span></li>
                                                <li><span>Type</span><span>xxx</span></li>
                                            </ul>
                                            <p>(ReactJS) Location : Bethesda, Maryland Duration : 10 Months Work Requirements : US Citizen, GC Holders or Authorized to Work in the US Overview: We are seeking a senior</p>
                                        </div>
                                        <div class="card-vacancy-footer"><a class="btn btn-primary" href="#">View Details</a><a class="btn btn-outline-primary" href="#">Dismiss</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
