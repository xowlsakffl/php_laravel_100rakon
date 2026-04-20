# 백락온 쇼핑몰

![100rakon 쇼핑몰 화면](https://user-images.githubusercontent.com/50791439/194876606-79a5b9c2-52ae-4b3b-ba15-ee29a8bb3155.PNG)

Laravel 6 기반의 건강식품 쇼핑몰 프로젝트입니다. 일반 상품 판매, 정기배송 상품, 특별상품 주문, Toss Payments 결제 연동, 회원/배송지/주문 관리, 관리자 페이지를 포함합니다.

포트폴리오 관점에서 핵심은 단순 화면 구현이 아니라 쇼핑몰 운영 흐름 전체를 Laravel MVC 구조로 구현한 점입니다. 주문 생성, 장바구니, 결제 콜백, 주문 상태 변경, 관리자 CRUD, 이미지 업로드, SMS 알림 기록까지 하나의 서비스 흐름으로 연결되어 있습니다.

## 주요 기능

- 회원가입, 로그인, 이메일 인증
- 카카오/네이버 소셜 로그인 연동 구조
- 상품 목록, 상품 상세, 장바구니
- 일반 주문, 정기배송 주문, 특별상품 주문
- Toss Payments 결제 성공/실패/가상계좌 콜백 처리
- 주문 상태와 주문 히스토리 관리
- 배송지 저장 및 재사용
- 고객 문의 등록 및 관리자 확인
- 상품/카테고리/회원/주문 관리자 페이지
- 상품 이미지 업로드 및 삭제
- Aligo SMS 알림 발송 내역 저장

## 기술 스택

- PHP 7.3+
- Laravel 6
- MySQL
- Blade
- Laravel Mix
- Sass
- Toss Payments
- Aligo SMS
- Kakao/Naver OAuth

## 프로젝트 구조

```text
100rakon_com/
├── app/                    # Model, Controller, Middleware, Provider
├── config/                 # Laravel 실행 설정
├── database/
│   ├── migrations/          # 테이블 스키마
│   ├── factories/
│   └── seeds/
├── public/                 # 웹 루트, 빌드된 정적 파일
├── resources/
│   ├── views/               # Blade 화면
│   ├── sass/                # 쇼핑몰/관리자 스타일
│   └── js/
├── routes/                 # web/api route
├── storage/                # 업로드/캐시/로그
└── bootstrap/              # Laravel bootstrap
```

## 실행 준비

```bash
cd 100rakon_com
composer install
npm install
cp .env.example .env
php artisan key:generate
```

PowerShell:

```powershell
Set-Location 100rakon_com
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
```

`.env`에서 DB 정보를 설정한 뒤 마이그레이션을 실행합니다.

```bash
php artisan migrate
php artisan storage:link
npm run dev
php artisan serve
```

## 주요 환경변수

| 변수 | 설명 |
| --- | --- |
| `APP_URL` | 서비스 URL. Toss 콜백 URL 생성에 사용 |
| `DB_DATABASE` | MySQL 데이터베이스명 |
| `DB_USERNAME` | DB 계정 |
| `DB_PASSWORD` | DB 비밀번호 |
| `TOSS_CLIENT_KEY` | Toss Payments 클라이언트 키 |
| `TOSS_SECRET_KEY` | Toss Payments 시크릿 키 |
| `TOSS_WEBHOOK_SECRET` | Toss 가상계좌/웹훅 검증용 secret |
| `ALIGO_USER_ID` | Aligo SMS 계정 |
| `ALIGO_API_KEY` | Aligo SMS API Key |
| `ALIGO_SENDER` | SMS 발신번호 |
| `SHOP_ADMIN_PHONE` | 운영자 알림 수신 번호 |
| `SHOP_BANK_ACCOUNT_TEXT` | 무통장 입금 안내 계좌 문구 |
| `KAKAO_CLIENT_ID` | 카카오 OAuth Client ID |
| `NAVER_CLIENT_ID` | 네이버 OAuth Client ID |

실제 결제 키, SMS 키, 운영자 연락처, 입금 계좌는 코드에 넣지 않고 `.env`에서 관리합니다.

## 보완한 부분

- Laravel 실행에 필요한 `bootstrap/`과 `config/` 구조 복구
- `.env.example`과 `.gitignore` 추가
- 관리자 접근 미들웨어에서 비로그인 사용자의 null 접근 오류 방지
- 관리자 권한이 없는 사용자는 403으로 차단
- 허용 IP 환경변수명을 `APP_ALLOW_IPS`로 통일
- 상품 상세 조회를 `findOrFail`로 변경해 없는 상품 접근 시 404 처리
- 주문 페이지 진입 라우트에 인증 미들웨어 적용
- Toss 가상계좌 콜백의 `secret` 검증 추가
- 잘못된 resource parameter(`oscdx?`, `sgcdx?`, `sgdx?`) 정리
- 중복 등록된 특별상품 주문 관리자 라우트 제거
- SMS API Key, 운영자 전화번호, 입금 계좌 하드코딩 제거
- README 인코딩 깨짐 수정 및 실행 방법 재작성

