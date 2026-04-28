# 백락온 쇼핑몰

![100rakon 쇼핑몰 화면](https://user-images.githubusercontent.com/50791439/194876606-79a5b9c2-52ae-4b3b-ba15-ee29a8bb3155.PNG)

백락온은 건강식품 판매를 위한 Laravel 기반 쇼핑몰 프로젝트입니다. 일반 상품 판매, 정기배송 상품, 연계상품 주문, Toss Payments 결제, 회원/배송지/주문 관리, 관리자 백오피스를 하나의 서비스 흐름으로 구성한 커머스 애플리케이션입니다.

이 프로젝트는 단순 상품 진열 페이지가 아니라, 회원가입과 소셜 로그인, 장바구니, 주문 생성, 결제 콜백, 주문 상태 관리, 상품 이미지 업로드, 관리자 CRUD, SMS 알림 기록까지 포함한 실서비스형 쇼핑몰입니다.


## 프로젝트 개요

- 건강식품 일반 상품 판매
- 정기배송 상품 구독형 주문
- 연계상품 별도 주문 흐름
- Toss Payments 결제 및 가상계좌 콜백 처리
- 이메일 인증 회원가입과 소셜 로그인
- 배송지/주문/회원 개인화 기능
- 관리자 백오피스 기반 상품/주문/회원 운영
- SMS 알림 전송 이력 관리

## 이 저장소가 맡는 역할

백락온 서비스는 크게 다음 흐름으로 구성됩니다.

- 사용자 구매 계층: 상품 탐색, 장바구니, 주문, 결제, 마이페이지
- 운영 계층: 상품/카테고리/주문/회원/문의 관리
- 외부 연동 계층: Toss Payments, Aligo SMS, Kakao/Naver OAuth

이 저장소는 위 세 계층을 한 Laravel 프로젝트 안에서 함께 처리합니다. 사용자 구매 화면과 관리자 백오피스가 분리된 별도 저장소가 아니라, 하나의 애플리케이션 안에서 연결되는 구조입니다.

## 핵심 서비스 흐름

1. 사용자가 일반 상품, 정기배송 상품, 연계상품 페이지를 탐색합니다.
2. 로그인 사용자 기준으로 장바구니 또는 바로주문 흐름을 진행합니다.
3. 주문 생성 후 Toss Payments 결제를 시도합니다.
4. 결제 성공/가상계좌 콜백이 들어오면 주문 상태와 이력이 갱신됩니다.
5. 필요 시 Aligo SMS로 운영 알림이 전송되고 이력이 저장됩니다.
6. 사용자는 마이페이지에서 주문/배송지/회원정보를 관리합니다.
7. 운영자는 `/admin` 이하 백오피스에서 상품, 주문, 정기배송, 연계상품, 문의, 회원을 관리합니다.

## 주요 기능

### 1. 회원 및 인증

- 회원가입, 로그인, 이메일 인증
- Kakao / Naver 소셜 로그인
- 내 정보 수정 및 탈퇴

주요 경로:

- `/login`
- `/register`
- `/social/{provider}`
- `/myinfo`

### 2. 일반 상품 쇼핑

- 상품 목록 및 상세 조회
- 장바구니 담기/삭제
- 일반 주문 생성 및 주문 저장

주요 경로:

- `GET /product`
- `GET /product/{pdx}`
- `GET /order/basket`
- `POST /order`
- `POST /order-save`

### 3. 정기배송 및 연계상품

- 정기배송 상품 목록/상세/주문
- 연계상품 별도 목록/상세/주문
- 일반 주문과 분리된 주문 모델 관리

주요 경로:

- `GET /subscrib`
- `GET /subscrib/{sgdx}`
- `POST /subscrib/order`
- `POST /subscrib/order-save`
- `GET /outstand`
- `GET /outstand/{osdx}`
- `POST /outstand/order`
- `POST /outstand/order-save`

### 4. 결제 및 외부 연동

- Toss Payments 결제 성공 콜백 처리
- 가상계좌 입금 상태 콜백 처리
- 결제 결과를 주문/정기배송 주문 상태에 반영
- Aligo SMS 운영 알림 전송 및 기록 저장

관련 구성:

- `app/Http/Controllers/TossController.php`
- `app/PayTossTransaction.php`
- `app/SmsSend.php`

### 5. 마이페이지 및 고객지원

- 일반 주문/정기배송 주문 조회
- 비회원 연계상품 주문 조회
- 배송지 CRUD
- QnA 등록

주요 경로:

- `/myorder`
- `/myorder-subscrib`
- `/myorder-outstand`
- `/myaddress`
- `/qna`

### 6. 관리자 백오피스

- 회원 관리
- 상품/카테고리 관리
- 연계상품/연계상품 카테고리 관리
- 정기배송 상품/카테고리 관리
- 일반 주문/정기배송 주문/연계상품 주문 관리
- 고객 문의 관리
- 관리자 전용 `check.admin` 미들웨어로 접근 제어

주요 경로:

- `/admin/home`
- `/admin/users`
- `/admin/categories`
- `/admin/products`
- `/admin/orders`
- `/admin/subscrib-orders`
- `/admin/outstand-orders`
- `/admin/qnas`

## 기술 스택

### Backend

![PHP](https://img.shields.io/badge/PHP-7.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-6-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-Template%20Engine-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Laravel Socialite](https://img.shields.io/badge/Socialite-Kakao%20%2F%20Naver-FFCD00?style=for-the-badge)
![Toss Payments](https://img.shields.io/badge/Toss%20Payments-Payment%20Gateway-3182F6?style=for-the-badge)
![Aligo SMS](https://img.shields.io/badge/Aligo-SMS-0F766E?style=for-the-badge)
![Composer](https://img.shields.io/badge/Composer-Package%20Manager-885630?style=for-the-badge&logo=composer&logoColor=white)

### Frontend / Asset Build

`100rakon_com/package.json` 기준:

![Laravel Mix](https://img.shields.io/badge/Laravel%20Mix-4.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Axios](https://img.shields.io/badge/Axios-0.19-5A29E4?style=for-the-badge&logo=axios&logoColor=white)
![Lodash](https://img.shields.io/badge/Lodash-4.17-3492FF?style=for-the-badge&logo=lodash&logoColor=white)
![Sass](https://img.shields.io/badge/Sass-1.15-CC6699?style=for-the-badge&logo=sass&logoColor=white)
![Sass Loader](https://img.shields.io/badge/Sass%20Loader-7.1-CC6699?style=for-the-badge)
![Vue Template Compiler](https://img.shields.io/badge/Vue%20Template%20Compiler-2.6-42B883?style=for-the-badge&logo=vuedotjs&logoColor=white)
![Boxicons](https://img.shields.io/badge/Boxicons-2.1-2563EB?style=for-the-badge)

## 프로젝트 구조

```text
100rakon_com/
├── app/
│   ├── Http/Controllers/        # 쇼핑몰, 주문, 결제, 관리자 컨트롤러
│   ├── Http/Middleware/         # 관리자 권한, 배포 모드 검사
│   ├── Product.php              # 일반 상품 모델
│   ├── Subscrib*.php            # 정기배송 관련 모델
│   ├── Outstand*.php            # 연계상품 관련 모델
│   ├── Order*.php               # 일반 주문 관련 모델
│   ├── PayTossTransaction.php   # Toss 결제 이력
│   └── SmsSend.php              # SMS 발송 이력
├── config/                      # Laravel 및 외부 서비스 설정
├── database/
│   ├── migrations/              # 상품/주문/정기배송/결제/QnA 테이블
│   ├── factories/
│   └── seeds/
├── public/                      # 웹 루트 및 빌드 결과물
├── resources/
│   ├── views/                   # mall, auth, admin Blade 화면
│   ├── sass/                    # 쇼핑몰/관리자 스타일
│   └── js/
├── routes/
│   ├── web.php                  # 쇼핑몰/관리자 라우트
│   └── api.php
├── storage/                     # 업로드, 캐시, 로그
└── bootstrap/
```

## 데이터 모델 관점의 특징

주요 모델은 다음 범위로 나뉩니다.

- 회원/개인화: `User`, `UserAddress`
- 일반 상품: `Product`, `ProductCategory`
- 일반 주문: `Order`, `OrderItem`, `OrderBasket`, `OrderHistory`
- 정기배송: `SubscribGood`, `SubscribGoodCategory`, `SubscribOrder`, `SubscribOrderItem`, `SubscribOrderHistory`
- 연계상품: `Outstand`, `OutstandCategory`, `OutstandOrder`, `OutstandItem`, `OutstandHistory`
- 외부 연동: `PayTossTransaction`, `SmsSend`
- 고객지원: `Qna`

즉, 단일 주문 테이블만 있는 간단한 쇼핑몰이 아니라, 일반 주문/정기배송/연계상품을 분리해서 관리하는 구조입니다.

## 실행 준비

```bash
cd 100rakon_com
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run dev
php artisan serve
```

PowerShell:

```powershell
Set-Location 100rakon_com
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run dev
php artisan serve
```

기본 개발 서버는 `http://127.0.0.1:8000` 또는 `http://localhost:8000`에서 실행됩니다.

## 주요 환경 변수

| 변수 | 설명 |
| --- | --- |
| `APP_URL` | 서비스 기본 URL. Toss 리다이렉트/콜백 경로 생성에 사용 |
| `APP_ALLOW_IPS` | 허용 IP 목록. `|` 구분 |
| `DB_DATABASE` | MySQL 데이터베이스명 |
| `DB_USERNAME` | DB 계정 |
| `DB_PASSWORD` | DB 비밀번호 |
| `TOSS_CLIENT_KEY` | Toss Payments 클라이언트 키 |
| `TOSS_SECRET_KEY` | Toss Payments 시크릿 키 |
| `TOSS_WEBHOOK_SECRET` | Toss 가상계좌 콜백 검증용 secret |
| `ALIGO_USER_ID` | Aligo SMS 계정 |
| `ALIGO_API_KEY` | Aligo SMS API Key |
| `ALIGO_SENDER` | SMS 발신 번호 |
| `ALIGO_TEST_MODE` | SMS 테스트 모드 |
| `SHOP_ADMIN_PHONE` | 운영 알림 수신 번호 |
| `SHOP_CUSTOMER_CENTER_PHONE` | 고객센터 전화번호 |
| `SHOP_CUSTOMER_CENTER_EMAIL` | 고객센터 이메일 |
| `SHOP_BANK_ACCOUNT_TEXT` | 무통장 입금 안내 문구 |
| `KAKAO_CLIENT_ID` | Kakao OAuth Client ID |
| `KAKAO_CLIENT_SECRET` | Kakao OAuth Secret |
| `KAKAO_REDIRECT_URI` | Kakao 콜백 URI |
| `NAVER_CLIENT_ID` | Naver OAuth Client ID |
| `NAVER_CLIENT_SECRET` | Naver OAuth Secret |
| `NAVER_REDIRECT_URI` | Naver 콜백 URI |

실제 결제 키, SMS 발신 정보, 운영 연락처, 계좌 안내 문구는 코드 하드코딩이 아니라 `.env`에서 관리하는 구조입니다.

## 현재 코드 기준 참고 사항

- 관리자 기능은 별도 프로젝트가 아니라 같은 앱 내부 `/admin` 네임스페이스로 구성되어 있습니다.
- `check.admin` 미들웨어는 로그인 여부와 `super === 'Y'` 권한을 함께 검사합니다.
- Toss 결제 성공/가상계좌 콜백은 주문 상태와 주문 이력을 함께 갱신하고, 운영 알림 SMS 기록도 남깁니다.
- 따라서 이 프로젝트는 단순 쇼핑몰 UI가 아니라, **결제/회원/주문/백오피스가 연결된 실무형 Laravel 커머스 프로젝트**로 소개하는 편이 정확합니다.

## 보완한 부분

- Laravel 실행에 필요한 `bootstrap/`과 `config/` 구조 복구
- `.env.example`과 `.gitignore` 추가
- 관리자 접근 미들웨어에서 비로그인 사용자 null 접근 오류 방지
- 관리자 권한이 없는 사용자는 `403`으로 차단
- 허용 IP 환경변수를 `APP_ALLOW_IPS`로 통일
- 상품 상세 조회를 `findOrFail`로 변경해 없는 상품 접근 시 `404` 처리
- 주문 페이지 진입 라우트에 인증 미들웨어 적용
- Toss 가상계좌 콜백에 `secret` 검증 추가
- 잘못된 resource parameter(`oscdx`, `sgcdx`, `sgdx`) 정리
- 중복 등록되던 연계상품 주문 관리자 라우트 제거
- SMS API Key, 운영자 전화번호, 입금 계좌 하드코딩 제거
- README 인코딩 깨짐 수정 및 실행 방법 재작성

## 주의 사항

- 이 저장소에는 운영 DB, 실제 결제 키, SMS 계정 정보가 포함되어 있지 않습니다.
- `public/`에 빌드 결과물이 포함되어 있어도 수정 개발은 `resources/`와 Laravel Mix 기준으로 진행하는 편이 맞습니다.
- Laravel 6 기반 프로젝트이므로 최신 Laravel 프로젝트와 디렉터리/설정 관례가 일부 다를 수 있습니다.
- 결제와 SMS는 외부 서비스 연동 정보가 있어야 실제 동작합니다.
