<x-home-layout>
    @push('css')
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
    @endpush
    <section class="bg-theme faq-page py-5">
        <div class="container">
            <div class="row">
                
                <!-- <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-9">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">All</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">Payment</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">Food</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-refund-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-refund" type="button" role="tab"
                                        aria-controls="pills-refund" aria-selected="false">Refund</button>
                                </li>
                            </ul>

                        </div>
                        <div class="col-lg-3">
                            <div class="search-bar">
                                <form>
                                    <label for="searchQuery">
                                        <i class="far fa-search"></i>
                                    </label>
                                    <input type="search" id="searchQuery" name="searchQuery" placeholder="Search" />
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-12">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="accordion" id="accordionExample">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            Are you open now?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            We are opening on the same day as the Game of Thrones Finale
                                                            Season Premiere.
                                                            (15th April IST)
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                            aria-expanded="false" aria-controls="collapseTwo">
                                                            Will you show new releases?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Atque blanditiis commodi perferendis ullam quo dolore. Illum
                                                            exercitationem nesciunt labore autem.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                            aria-expanded="false" aria-controls="collapseThree">
                                                            How many people can you accommodate?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse"
                                                        aria-labelledby="headingThree"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Aperiam incidunt dicta suscipit doloremque explicabo
                                                            reprehenderit accusamus hic labore distinctio et?
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingFour">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                            aria-expanded="false" aria-controls="collapseFive">
                                                            Can I book now?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFour" class="accordion-collapse collapse"
                                                        aria-labelledby="headingFour"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Facere quia tempora modi veritatis doloremque obcaecati
                                                            repellendus quasi voluptatibus cumque beatae.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingFive">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                                            aria-expanded="false" aria-controls="collapseFive">
                                                            Is food available?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFive" class="accordion-collapse collapse"
                                                        aria-labelledby="headingFive"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Facere quia tempora modi veritatis doloremque obcaecati
                                                            repellendus quasi voluptatibus cumque beatae.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingSix">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                                            aria-expanded="false" aria-controls="collapseSix">
                                                            Is alcohol available?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSix" class="accordion-collapse collapse"
                                                        aria-labelledby="headingSix"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic
                                                            repudiandae voluptates natus nesciunt eaque mollitia ab nam
                                                            autem molestias quos?
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingSev">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseSev"
                                                            aria-expanded="false" aria-controls="collapseSev">
                                                            Can we bring our own food?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSev" class="accordion-collapse collapse"
                                                        aria-labelledby="headingSev"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum
                                                            a impedit voluptate, unde sequi at esse velit nobis quas
                                                            quasi.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="accordion" id="accordionExample">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            Are you open now?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            We are opening on the same day as the Game of Thrones Finale
                                                            Season Premiere.
                                                            (15th April IST)
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                            aria-expanded="false" aria-controls="collapseTwo">
                                                            Will you show new releases?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Atque blanditiis commodi perferendis ullam quo dolore. Illum
                                                            exercitationem nesciunt labore autem.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                            aria-expanded="false" aria-controls="collapseThree">
                                                            How many people can you accommodate?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse"
                                                        aria-labelledby="headingThree"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Aperiam incidunt dicta suscipit doloremque explicabo
                                                            reprehenderit accusamus hic labore distinctio et?
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingFour">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                            aria-expanded="false" aria-controls="collapseFive">
                                                            Can I book now?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFour" class="accordion-collapse collapse"
                                                        aria-labelledby="headingFour"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Facere quia tempora modi veritatis doloremque obcaecati
                                                            repellendus quasi voluptatibus cumque beatae.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingFive">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                                            aria-expanded="false" aria-controls="collapseFive">
                                                            Is food available?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFive" class="accordion-collapse collapse"
                                                        aria-labelledby="headingFive"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Facere quia tempora modi veritatis doloremque obcaecati
                                                            repellendus quasi voluptatibus cumque beatae.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingSix">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                                            aria-expanded="false" aria-controls="collapseSix">
                                                            Is alcohol available?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSix" class="accordion-collapse collapse"
                                                        aria-labelledby="headingSix"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic
                                                            repudiandae voluptates natus nesciunt eaque mollitia ab nam
                                                            autem molestias quos?
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingSev">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseSev"
                                                            aria-expanded="false" aria-controls="collapseSev">
                                                            Can we bring our own food?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSev" class="accordion-collapse collapse"
                                                        aria-labelledby="headingSev"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum
                                                            a impedit voluptate, unde sequi at esse velit nobis quas
                                                            quasi.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="accordion" id="accordionExample">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            Are you open now?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            We are opening on the same day as the Game of Thrones Finale
                                                            Season Premiere.
                                                            (15th April IST)
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                            aria-expanded="false" aria-controls="collapseTwo">
                                                            Will you show new releases?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Atque blanditiis commodi perferendis ullam quo dolore. Illum
                                                            exercitationem nesciunt labore autem.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                            aria-expanded="false" aria-controls="collapseThree">
                                                            How many people can you accommodate?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse"
                                                        aria-labelledby="headingThree"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Aperiam incidunt dicta suscipit doloremque explicabo
                                                            reprehenderit accusamus hic labore distinctio et?
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingFour">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                            aria-expanded="false" aria-controls="collapseFive">
                                                            Can I book now?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFour" class="accordion-collapse collapse"
                                                        aria-labelledby="headingFour"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Facere quia tempora modi veritatis doloremque obcaecati
                                                            repellendus quasi voluptatibus cumque beatae.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingFive">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                                            aria-expanded="false" aria-controls="collapseFive">
                                                            Is food available?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFive" class="accordion-collapse collapse"
                                                        aria-labelledby="headingFive"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Facere quia tempora modi veritatis doloremque obcaecati
                                                            repellendus quasi voluptatibus cumque beatae.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingSix">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                                            aria-expanded="false" aria-controls="collapseSix">
                                                            Is alcohol available?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSix" class="accordion-collapse collapse"
                                                        aria-labelledby="headingSix"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic
                                                            repudiandae voluptates natus nesciunt eaque mollitia ab nam
                                                            autem molestias quos?
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingSev">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseSev"
                                                            aria-expanded="false" aria-controls="collapseSev">
                                                            Can we bring our own food?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSev" class="accordion-collapse collapse"
                                                        aria-labelledby="headingSev"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum
                                                            a impedit voluptate, unde sequi at esse velit nobis quas
                                                            quasi.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-refund" role="tabpanel"
                            aria-labelledby="pills-refund-tab">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="accordion" id="accordionExample">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            Are you open now?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        aria-labelledby="headingOne"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            We are opening on the same day as the Game of Thrones Finale
                                                            Season Premiere.
                                                            (15th April IST)
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                            aria-expanded="false" aria-controls="collapseTwo">
                                                            Will you show new releases?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                                        aria-labelledby="headingTwo"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Atque blanditiis commodi perferendis ullam quo dolore. Illum
                                                            exercitationem nesciunt labore autem.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                            aria-expanded="false" aria-controls="collapseThree">
                                                            How many people can you accommodate?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse"
                                                        aria-labelledby="headingThree"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Aperiam incidunt dicta suscipit doloremque explicabo
                                                            reprehenderit accusamus hic labore distinctio et?
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingFour">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                            aria-expanded="false" aria-controls="collapseFive">
                                                            Can I book now?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFour" class="accordion-collapse collapse"
                                                        aria-labelledby="headingFour"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Facere quia tempora modi veritatis doloremque obcaecati
                                                            repellendus quasi voluptatibus cumque beatae.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingFive">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                                            aria-expanded="false" aria-controls="collapseFive">
                                                            Is food available?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseFive" class="accordion-collapse collapse"
                                                        aria-labelledby="headingFive"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            Facere quia tempora modi veritatis doloremque obcaecati
                                                            repellendus quasi voluptatibus cumque beatae.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingSix">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                                            aria-expanded="false" aria-controls="collapseSix">
                                                            Is alcohol available?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSix" class="accordion-collapse collapse"
                                                        aria-labelledby="headingSix"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic
                                                            repudiandae voluptates natus nesciunt eaque mollitia ab nam
                                                            autem molestias quos?
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingSev">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseSev"
                                                            aria-expanded="false" aria-controls="collapseSev">
                                                            Can we bring our own food?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseSev" class="accordion-collapse collapse"
                                                        aria-labelledby="headingSev"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum
                                                            a impedit voluptate, unde sequi at esse velit nobis quas
                                                            quasi.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="col-lg-9 mx-auto">
                    <h2 class="mb-4"><b>FAQ</b></h2>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    1. Do you provide the screening content for the private screenings?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>
                                        Unfortunately we do not provide the screening content due to copyright issues.
                                        Customers are required to bring their own OTT logins.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    2. Is alcohol served at Binge Club, and can guests smoke on the premises?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    We do not serve alcohol, and smoking is prohibited within our premises.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    3. Are there age restrictions for booking at Binge Club?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Persons under the age of 18 must book accompanied by an adult
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    4. Can I bring my pet with me to Binge Club?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Pets are not allowed on our premises.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    5. Is the premises at Binge Club under surveillance?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Yes, the premises are under CCTV surveillance for the safety and security of all
                                    guests.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    6. Can I bring my own decorations for special occasions?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    No, we provide the decor. No external decor items are allowed, specifically poppers,
                                    snow sprays, etc.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSeven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    7. Are there any charges for bringing outside food?
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Standard cleaning charges of ₹100 will be applied if outside food is consumed.
                                    In case of excessive mess, ₹500 will be levied.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingEight">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                    8. Can I bring my own snacks, or are they provided by Binge Club?
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Snack items like popcorn and nachos are served by us and are not allowed from
                                    outside.
                                    Guests are permitted to bring food items through services like Swiggy or Zomato.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingNine">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                    9. Can we bring content on pen-drives?
                                </button>
                            </h2>
                            <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Pen-drives are not compatible with our system. However, we offer a seamless
                                    entertainment
                                    experience through streaming services and casting options. Should you have special
                                    celebration
                                    videos you'd like to share, simply send them to our point of contact via WhatsApp,
                                    and we'll
                                    ensure they're played at the appropriate moment during your event.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTen">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                                    10. What happens if there are technical issues during my screening?
                                </button>
                            </h2>
                            <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    In case of issues from our end, such as a Wi-Fi shutdown or technical problems,
                                    compensation shall be provided to ensure a satisfying experience for our guests.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-home-layout>