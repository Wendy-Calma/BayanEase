@extends('layouts.public')

@section('title', 'Smart Barangay - Home')

@section('content')
<!-- Hero Section -->
<section style="background: linear-gradient(135deg, #ff6b35 0%, #ff8c42 100%); color: white; padding: 80px 20px; text-align: center; margin-top: -5px; margin-left: 0; margin-right: 0;">
    <div class="container">
        <h1 style="font-size: 48px; font-weight: 700; margin-bottom: 30px;">Request Barangay Documents Online</h1>
        <p style="font-size: 18px; margin-bottom: 50px; max-width: 600px; margin-left: auto; margin-right: auto;">Get your barangay clearance, certificates, and permits in just 2-3 business days. No more long lines, no more hassles.</p>
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('register') }}" class="btn" style="background-color: white; color: #ff6b35; border: none; padding: 12px 35px; font-weight: 600; border-radius: 6px; text-decoration: none;">Get Started for Free</a>
            <a href="#how-it-works" class="btn" style="background-color: transparent; color: white; border: 2px solid white; padding: 12px 35px; font-weight: 600; border-radius: 6px; text-decoration: none;">Learn More</a>
        </div>
    </div>
</section>

<!-- Why Use Smart Barangay Section -->
<section style="padding: 80px 20px; background-color: #f8f9fa;">
    <div class="container">
        <h2 style="text-align: center; font-size: 36px; font-weight: 700; color: #2d3748; margin-bottom: 60px;">Why Use Bayan EASE?</h2>
        <p style="text-align: center; color: #718096; font-size: 16px; margin-bottom: 50px;">Modern, convenient, and hassle-free document processing</p>
        
        <div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 40px;">
            <!-- 24/7 Online Access -->
            <div style="background: white; padding: 40px 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="width: 60px; height: 60px; background-color: #e0e0e0; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                    <i class="fas fa-clock" style="color: #ff6b35;"></i>
                </div>
                <h5 style="font-weight: 600; color: #2d3748; margin-bottom: 10px; font-size: 18px;">24/7 Online Access</h5>
                <p style="color: #718096; line-height: 1.6;">Submit document requests anytime, anywhere. No need to visit the office during work hours.</p>
            </div>

            <!-- Real-Time SMS Updates -->
            <div style="background: white; padding: 40px 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="width: 60px; height: 60px; background-color: #e0e0e0; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                    <i class="fas fa-sms" style="color: #ff6b35;"></i>
                </div>
                <h5 style="font-weight: 600; color: #2d3748; margin-bottom: 10px; font-size: 18px;">Real-Time SMS Updates</h5>
                <p style="color: #718096; line-height: 1.6;">Get instant notifications via SMS and email when your document status is updated.</p>
            </div>

            <!-- Fast Processing -->
            <div style="background: white; padding: 40px 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="width: 60px; height: 60px; background-color: #e0e0e0; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                    <i class="fas fa-bolt" style="color: #ff6b35;"></i>
                </div>
                <h5 style="font-weight: 600; color: #2d3748; margin-bottom: 10px; font-size: 18px;">Fast Processing</h5>
                <p style="color: #718096; line-height: 1.6;">Quick processing time of 2-3 business days. Track your request status in real-time.</p>
            </div>

            <!-- Secure & Private -->
            <div style="background: white; padding: 40px 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="width: 60px; height: 60px; background-color: #e0e0e0; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                    <i class="fas fa-lock" style="color: #ff6b35;"></i>
                </div>
                <h5 style="font-weight: 600; color: #2d3748; margin-bottom: 10px; font-size: 18px;">Secure & Private</h5>
                <p style="color: #718096; line-height: 1.6;">Your personal information is encrypted and fully compliant with data privacy laws.</p>
            </div>

            <!-- Easy Tracking -->
            <div style="background: white; padding: 40px 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="width: 60px; height: 60px; background-color: #e0e0e0; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                    <i class="fas fa-map-location-dot" style="color: #ff6b35;"></i>
                </div>
                <h5 style="font-weight: 600; color: #2d3748; margin-bottom: 10px; font-size: 18px;">Easy Tracking</h5>
                <p style="color: #718096; line-height: 1.6;">Monitor all your requests in one dashboard. Get updates at every stage of the process.</p>
            </div>

            <!-- Eco-Friendly -->
            <div style="background: white; padding: 40px 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="width: 60px; height: 60px; background-color: #e0e0e0; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                    <i class="fas fa-leaf" style="color: #ff6b35;"></i>
                </div>
                <h5 style="font-weight: 600; color: #2d3748; margin-bottom: 10px; font-size: 18px;">Eco-Friendly</h5>
                <p style="color: #718096; line-height: 1.6;">Paperless process reduces environmental impact and simplifies the paperwork.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" style="padding: 80px 20px; background-color: white;">
    <div class="container">
        <h2 style="text-align: center; font-size: 36px; font-weight: 700; color: #2d3748; margin-bottom: 20px;">How it Works</h2>
        <p style="text-align: center; color: #718096; font-size: 16px; margin-bottom: 60px;">Three simple steps to get your document</p>
        
        <div style="display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap; gap: 40px; margin-bottom: 60px;">
            <!-- Step 1 -->
            <div style="text-align: center; flex: 1; min-width: 200px;">
                <div style="width: 80px; height: 80px; background-color: #ff6b35; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 700; margin: 0 auto 20px;">1</div>
                <h5 style="font-weight: 600; color: #2d3748; margin-bottom: 10px;">Submit Online</h5>
                <p style="color: #718096;">Create an account, select your document type, and upload required files.</p>
            </div>

            <!-- Step 2 -->
            <div style="text-align: center; flex: 1; min-width: 200px;">
                <div style="width: 80px; height: 80px; background-color: #ff6b35; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 700; margin: 0 auto 20px;">2</div>
                <h5 style="font-weight: 600; color: #2d3748; margin-bottom: 10px;">Get Updates</h5>
                <p style="color: #718096;">Receive SMS and email notifications as your request is processed.</p>
            </div>

            <!-- Step 3 -->
            <div style="text-align: center; flex: 1; min-width: 200px;">
                <div style="width: 80px; height: 80px; background-color: #ff6b35; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 36px; font-weight: 700; margin: 0 auto 20px;">3</div>
                <h5 style="font-weight: 600; color: #2d3748; margin-bottom: 10px;">Pick Up</h5>
                <p style="color: #718096;">Visit the barangay office when ready. Show your confirmation and collect.</p>
            </div>
        </div>
    </div>
</section>

<!-- Available Documents Section -->
<section style="padding: 80px 20px; background-color: #f8f9fa;">
    <div class="container">
        <h2 style="text-align: center; font-size: 36px; font-weight: 700; color: #2d3748; margin-bottom: 20px;">Available Documents</h2>
        <p style="text-align: center; color: #718096; font-size: 16px; margin-bottom: 60px;">Request these documents online</p>
        
        <div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            @forelse(\App\Models\DocumentType::where('is_active', true)->get() as $doc)
            <div style="background: white; border: 1px solid #e2e8f0; padding: 30px; border-radius: 8px; text-align: center;">
                <div style="width: 60px; height: 60px; background-color: #e0e0e0; border-radius: 8px; margin: 0 auto 20px;"></div>
                <h5 style="font-weight: 600; color: #2d3748; margin-bottom: 10px;">{{ $doc->name }}</h5>
                <p style="color: #718096; font-size: 14px;">{{ $doc->processing_days ?? 2 }}-{{ $doc->processing_days + 1 ?? 3 }} days</p>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #718096;">
                <p>No documents available at this time</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="padding: 80px 20px; background-color: white; text-align: center;">
    <div class="container">
        <h2 style="font-size: 36px; font-weight: 700; color: #2d3748; margin-bottom: 20px;">Ready to Get Started?</h2>
        <p style="color: #718096; font-size: 16px; margin-bottom: 40px;">Join hundreds of residents who are already enjoying faster document processing</p>
        
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('register') }}" class="btn" style="background-color: #ff6b35; color: white; border: none; padding: 12px 35px; font-weight: 600; border-radius: 6px; text-decoration: none;">Create Free Account</a>
            <a href="#" class="btn" style="background-color: transparent; color: #ff6b35; border: 2px solid #ff6b35; padding: 12px 35px; font-weight: 600; border-radius: 6px; text-decoration: none;">Contact Support</a>
        </div>
    </div>
</section>
@endsection