<main>
    <div class="container">
        <div class="page-title-container">
            <div class="row g-0">
                <div class="col-auto mb-2 mb-md-0 me-auto">
                    <div class="w-auto sw-md-30">
                        <h1 class="mb-0 pb-0 display-4" id="title">Calendrier</h1>
                    </div>
                </div>
                <div class="w-100 d-md-none"></div>
                <div class="col-auto d-flex align-items-start justify-content-end">
                    <button type="button" class="btn btn-outline-primary btn-icon btn-icon-only ms-1" id="goPrev">
                        <i data-acorn-icon="chevron-left"></i>
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-icon btn-icon-only ms-1" id="goNext">
                        <i data-acorn-icon="chevron-right"></i>
                    </button>
                </div>
                <div class="col col-md-auto d-flex align-items-start justify-content-end">
                    <a href="caleajou.php"><button type="button" class="btn btn-outline-primary btn-icon btn-icon-start ms-1 w-100 w-md-auto">
                            <i data-acorn-icon="plus"></i>
                            <span>Ajouter</a></span>
                    </button>
                </div>
            </div>
        </div>
        <section class="scroll-section" id="basicSingle">
            <div class="card mb-5">
                <div class="card-body">
                    <div class="row">
                        <?php if($monitors && count($monitors) > 0): ?>
                            <div class="col-12 col-sm-6 col-xl-4">
                                <div class="w-100">
                                    <label class="form-label">Moniteurs</label>
                                    <select class="selectBasic select-calendar__js" name="monitors[]" multiple>
                                        <?php foreach($monitors as $monitor): ?>
                                            <option value="<?php echo $monitor['value'] ?>"><?php echo $monitor['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if($disciplines && count($disciplines) > 0): ?>
                        <div class="col-12 col-sm-6 col-xl-4">
                            <div class="w-100">
                                <label class="form-label">Discipline</label>
                                <select class="selectBasic select-calendar__js" name="discipline">
                                    <option label="&nbsp;" value="none">-- Selectionner une discipline --</option>
                                    <?php foreach($disciplines as $discipline): ?>
                                        <option value="<?php echo $discipline['value'] ?>"><?php echo $discipline['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($installations && count($installations) > 0): ?>
                        <div class="col-12 col-sm-6 col-xl-4">
                            <div class="w-100">
                                <label class="form-label">Installation</label>
                                <select class="selectBasic select-calendar__js" name="installation">
                                    <option label="&nbsp;" value="none">-- Selectionner une installation --</option>
                                    <?php foreach($installations as $installation): ?>
                                        <option value="<?php echo $installation['value'] ?>"><?php echo $installation['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <div class="d-flex justify-content-between">
            <h2 class="small-title" id="calendarTitle">Title</h2>
            <button
                    class="btn btn-sm btn-icon btn-icon-only btn-foreground shadow align-top mt-n2"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    aria-haspopup="true"
            >
                <i data-acorn-icon="more-horizontal" data-acorn-size="15"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end shadow">
                <a class="dropdown-item" href="#" id="monthView">Mois</a>
                <a class="dropdown-item" href="#" id="weekView">Semaine</a>
                <a class="dropdown-item" href="#" id="dayView">Jour</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" id="goToday">Aujourd'hui</a>
            </div>
        </div>

        <div class="card cardCalendar">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>

    </div>
</main>
