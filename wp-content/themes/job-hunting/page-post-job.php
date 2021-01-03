<div class="results page">
    <div class="container">
        <div class="row">
            <div class="col-12" data-tab>
                <ul class="results-header results-header-large">
                    <li class="d-md-none" data-tab-value><span>Create New Job</span></li>
                    <li class="active" data-tab-item="create">Create New Job</li>
                    <li data-tab-item="duplicate">Duplicate Previous Job</li>
                </ul>
                <div class="results-content">
                    <div class="active" data-tab-content="create">
                        <form class="container-fluid p-0">
                            <div class="row mt-md-4">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-title">Job Title <span class="color-primary">*</span></label>
                                </div>
                                <div class="col-12 col-md-7">
                                    <input class="field-text" type="text" id="post-job-title" required>
                                </div>
                            </div>
                            <div class="row mt-3 mt-md-4">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-location">Job Location <span class="color-primary">*</span></label>
                                </div>
                                <div class="col-12 col-md-7">
                                    <input class="field-text" type="text" id="post-job-location" required>
                                </div>
                            </div>
                            <div class="row mt-3 mt-md-4">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <div class="field-label mb-2 mb-md-0 mt-md-3">Employment Type <span class="color-primary">*</span></div>
                                </div>
                                <div class="col-12 col-md-7">
                                    <div class="ys-select ys-select-bordered" data-select><span data-select-value>Select employment type</span>
                                        <ul>
                                            <li data-select-item>Type 1</li>
                                            <li data-select-item>Type 2</li>
                                            <li data-select-item>Type 3</li>
                                        </ul>
                                        <input class="d-none" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 mt-md-4">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-description">Job Description <span class="color-primary">*</span></label>
                                </div>
                                <div class="col-12 col-md-7">
                                    <textarea class="field-textarea" id="post-job-description"></textarea>
                                </div>
                            </div>
                            <div class="row mt-3 mt-md-5">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <div class="field-label mb-2 mb-md-0">Benefits <span class="color-primary">*</span></div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <fieldset>
                                        <input type="checkbox" name="post-job-benefits" id="post-job-benefits-1">
                                        <label for="post-job-benefits-1">Medical Insurance</label>
                                    </fieldset>
                                    <fieldset>
                                        <input type="checkbox" name="post-job-benefits" id="post-job-benefits-2">
                                        <label for="post-job-benefits-2">Dental Insurance</label>
                                    </fieldset>
                                    <fieldset>
                                        <input type="checkbox" name="post-job-benefits" id="post-job-benefits-3">
                                        <label for="post-job-benefits-3">Vision Insurance</label>
                                    </fieldset>
                                </div>
                                <div class="col-12 col-md-3">
                                    <fieldset>
                                        <input type="checkbox" name="post-job-benefits" id="post-job-benefits-4">
                                        <label for="post-job-benefits-4">401K</label>
                                    </fieldset>
                                    <fieldset>
                                        <input type="checkbox" name="post-job-benefits" id="post-job-benefits-5">
                                        <label for="post-job-benefits-5">Life Insurance</label>
                                    </fieldset>
                                    <fieldset>
                                        <input type="checkbox" name="post-job-benefits" id="post-job-benefits-6">
                                        <label for="post-job-benefits-6">None of These</label>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row mt-3 mt-md-5">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <div class="field-label mb-2 mb-md-0 mt-md-3">Compensation Range <span class="color-primary">*</span></div>
                                    <p>Job postings with compensation data receive maximum visibility.</p>
                                </div>
                                <div class="col-12 col-md-7">
                                    <div class="field-prices">
                                        <label><span>$</span>
                                            <input class="field-text" type="text">
                                        </label><span>to</span>
                                        <label><span>$</span>
                                            <input class="field-text" type="text">
                                        </label>
                                    </div>
                                    <div class="d-md-flex justify-content-md-between mt-3 mt-md-4 align-items-start flex-wrap">
                                        <div class="ys-select ys-select-bordered mt-3 mt-md-0 mr-md-4" data-select><span data-select-value>USD</span>
                                            <ul>
                                                <li class="active" data-select-item>USD</li>
                                                <li data-select-item>EURO</li>
                                            </ul>
                                            <input class="d-none" type="text">
                                        </div>
                                        <div class="ys-select ys-select-bordered mt-3 mt-md-0 flex-md-grow-1 mr-lg-4" data-select><span data-select-value>Annualy</span>
                                            <ul>
                                                <li class="active" data-select-item>Annualy</li>
                                                <li data-select-item>another item</li>
                                            </ul>
                                            <input class="d-none" type="text">
                                        </div>
                                        <div class="mt-3 mt-md-4 mt-lg-3">
                                            <input type="checkbox" name="post-job-commission" id="post-job-commission">
                                            <label for="post-job-commission">Plus commission</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 mt-md-5">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <label class="field-label m-0 mt-md-3" for="post-job-address">Street Address <span class="color-primary">*</span></label>
                                    <p>Some job boards allow users to search with a map. Enter your full street address for better visibility.</p>
                                </div>
                                <div class="col-12 col-md-7">
                                    <input class="field-text" type="text" id="post-job-address" required>
                                </div>
                            </div>
                            <div class="row mt-3 mt-md-5">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <div class="field-label mb-2 mb-md-0 mt-md-2">Skills <span class="color-primary">*</span></div>
                                    <p>Target the exact job seekers you need by adding skill keywords below.</p>
                                </div>
                                <div class="col-12 col-md-7 field-skills">
                                    <ul class="field-skills-list mb-md-4">
                                        <li><span>Adobe Photoshop</span><span class="field-skills-close"></span></li>
                                        <li><span>Figma</span><span class="field-skills-close"></span></li>
                                    </ul>
                                    <div class="field-skills-panel d-flex flex-column flex-md-row">
                                        <label class="d-block mb-0 mt-3 mt-md-0 flex-md-grow-1 mr-md-4">
                                            <input class="field-text" type="text">
                                        </label>
                                        <button class="btn btn-primary mt-3 m-md-0 px-md-4" type="button">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 mt-md-5">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-company">Hiring Company <span class="color-primary">*</span></label>
                                </div>
                                <div class="col-12 col-md-7">
                                    <input class="field-text" type="text" id="post-job-company" required>
                                </div>
                            </div>
                            <div class="row mt-3 mt-md-4">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-why">Why Work at This Company</label>
                                </div>
                                <div class="col-12 col-md-7">
                                    <input class="field-text" type="text" id="post-job-why" required>
                                </div>
                            </div>
                            <div class="row mt-3 mt-md-4">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <label class="field-label mb-2 mb-md-0 mt-md-3" for="post-job-company-description">Hiring Company Description</label>
                                    <p>Please note: editing this description will affect all jobs at this hiring company.</p>
                                </div>
                                <div class="col-12 col-md-7">
                                    <textarea class="field-textarea" id="post-job-company-description"></textarea>
                                </div>
                            </div>
                            <div class="row mt-3 mt-md-5">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <label class="field-label mb-2 mb-md-0" for="post-job-company-description">Send New Candidates To <span class="color-primary">*</span></label>
                                    <p>Alert emails with new candidates will be sent to</p>
                                </div>
                                <div class="col-12 col-md-7">
                                    <fieldset>
                                        <input type="checkbox" name="post-job-send" id="post-job-send" checked>
                                        <label for="post-job-send">EmployerName (You!)</label>
                                    </fieldset>
                                    <div class="mt-md-2 d-flex flex-column flex-md-row">
                                        <label class="d-block m-0 mr-md-4 flex-grow-1">
                                            <input class="field-text" type="text" id="post-job-send-email">
                                        </label>
                                        <button class="btn btn-primary mt-3 m-md-0" type="button">Add Email</button>
                                    </div>
                                    <div class="mt-3 mt-md-5 d-flex">
                                        <input type="checkbox" name="post-job-send" id="post-job-send-1" checked>
                                        <label for="post-job-send-1">Add a FREE label indicating this job is extending offers during the COVID-19 crisis</label>
                                    </div>
                                    <div class="d-flex">
                                        <input type="checkbox" name="post-job-send" id="post-job-send-2" checked>
                                        <label for="post-job-send-2">Only show me candidates within 100 miles of this job's location</label>
                                    </div>
                                    <div class="d-flex">
                                        <input type="checkbox" name="post-job-send" id="post-job-send-3" checked>
                                        <label for="post-job-send-3">Accept applications without a resume</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row field-footer mt-3 pt-3 mt-md-5 pt-md-5">
                                <div class="col-12 col-md-5 col-xl-3">
                                    <p class="my-md-0">By clicking Save & Post Now, I agree that EcJobHunting may publish and/or distribute my job advertisement on its site and through its distribution partners.</p>
                                </div>
                                <div class="col-12 col-md-7 d-md-flex align-items-md-start">
                                    <button class="btn btn-primary mr-md-4" type="submit">Save & Post Now</button>
                                    <button class="btn btn-outline-primary" type="submit">Save Draft</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div data-tab-content="duplicate">
                        <form class="container-fluid p-0">
                            <div class="row mt-md-4">
                                <div class="col-12 col-xl-3">
                                    <label class="field-label mb-2 mb-md-0 mt-md-3 mt-xl-3" for="post-job-title-dublicate">Enter a Previous Job Title <span class="color-primary">*</span></label>
                                </div>
                                <div class="col-12 col-xl-7 mt-md-4 mt-xl-0">
                                    <input class="field-text" type="text" id="post-job-title-dublicate" required>
                                    <p class="mt-4"><strong>Important: </strong> Posting an exact copy of an active job in the same or nearby location will be rejected by the job boards</p>
                                    <button class="btn btn-primary btn-lg mt-4 mt-xl-5" type="submit">Dublicate Job</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>