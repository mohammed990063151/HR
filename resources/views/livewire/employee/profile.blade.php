<div>
    <h1 class="h4 mb-3 text-white">الملف الشخصي</h1>
    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card card-emp p-4">
                <h2 class="h6 text-muted-emp mb-3">بيانات الحساب</h2>
                <div class="mb-3">
                    <label class="form-label small text-muted-emp">الاسم</label>
                    <input type="text" class="form-control bg-dark text-white border-secondary" wire:model="name">
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted-emp">البريد</label>
                    <input type="email" class="form-control bg-dark text-white border-secondary" wire:model="email">
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <button type="button" class="btn btn-primary" wire:click="saveProfile">حفظ البيانات</button>

                <hr class="border-secondary my-4">

                <h2 class="h6 text-muted-emp mb-3">تغيير كلمة المرور</h2>
                <div class="mb-3">
                    <label class="form-label small text-muted-emp">كلمة المرور الجديدة</label>
                    <input type="password" class="form-control bg-dark text-white border-secondary" wire:model="password" autocomplete="new-password">
                    @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label small text-muted-emp">تأكيد</label>
                    <input type="password" class="form-control bg-dark text-white border-secondary" wire:model="password_confirmation">
                </div>
                <button type="button" class="btn btn-outline-light" wire:click="savePassword">تحديث كلمة المرور</button>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-emp p-4">
                <h2 class="h6 text-muted-emp mb-3">معلومات الوظيفة (للقراءة)</h2>
                <p><span class="text-muted-emp">القسم:</span> {{ $departmentName }}</p>
                <p><span class="text-muted-emp">الوردية:</span> {{ $shiftLine }}</p>
            </div>
        </div>
    </div>
</div>
