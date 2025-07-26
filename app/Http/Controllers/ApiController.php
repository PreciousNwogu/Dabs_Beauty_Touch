<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * Get available time slots for a specific date.
     */
    public function getAvailableTimeSlots(Request $request)
    {
        $date = $request->query('date');

        if (!$date) {
            return response()->json([
                'success' => false,
                'message' => 'Date is required'
            ], 400);
        }

        // Define all possible time slots
        $allTimeSlots = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
            '15:00', '15:30', '16:00', '16:30', '17:00', '17:30'
        ];

        // Get booked time slots for the date
        $bookedSlots = Booking::where('appointment_date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_time')
            ->toArray();

        // Filter out booked slots
        $availableSlots = array_diff($allTimeSlots, $bookedSlots);

        return response()->json([
            'success' => true,
            'available_slots' => array_values($availableSlots)
        ]);
    }

    /**
     * Get services offered.
     */
    public function getServices()
    {
        $services = [
            [
                'id' => 1,
                'name' => 'Box Braids',
                'description' => 'Classic protective style with square-shaped sections',
                'duration' => '4-6 hours',
                'price_range' => '£80-£150'
            ],
            [
                'id' => 2,
                'name' => 'Knotless Braids',
                'description' => 'Gentle braiding technique without knots at the root',
                'duration' => '5-7 hours',
                'price_range' => '£100-£180'
            ],
            [
                'id' => 3,
                'name' => 'Feed-in Braids',
                'description' => 'Natural-looking braids with gradual hair addition',
                'duration' => '3-5 hours',
                'price_range' => '£70-£120'
            ],
            [
                'id' => 4,
                'name' => 'Cornrows',
                'description' => 'Traditional close-to-scalp braiding style',
                'duration' => '2-4 hours',
                'price_range' => '£50-£90'
            ],
            [
                'id' => 5,
                'name' => 'Wig Installation',
                'description' => 'Professional wig fitting and styling',
                'duration' => '2-3 hours',
                'price_range' => '£60-£100'
            ],
            [
                'id' => 6,
                'name' => 'Hair Extensions',
                'description' => 'Quality hair extension installation',
                'duration' => '3-4 hours',
                'price_range' => '£80-£140'
            ],
            [
                'id' => 7,
                'name' => 'Silk Press',
                'description' => 'Smooth, silky hair styling treatment',
                'duration' => '2-3 hours',
                'price_range' => '£70-£110'
            ],
            [
                'id' => 8,
                'name' => 'Natural Hair Care',
                'description' => 'Washing, conditioning, and styling natural hair',
                'duration' => '1-2 hours',
                'price_range' => '£40-£70'
            ]
        ];

        return response()->json([
            'success' => true,
            'services' => $services
        ]);
    }

    /**
     * Get testimonials/reviews.
     */
    public function getTestimonials()
    {
        $testimonials = [
            [
                'id' => 1,
                'name' => 'Sarah Johnson',
                'service' => 'Knotless Braids',
                'rating' => 5,
                'comment' => 'Absolutely amazing! Precious did such a beautiful job with my knotless braids. They look so natural and feel comfortable. Highly recommend!',
                'date' => '2024-01-15'
            ],
            [
                'id' => 2,
                'name' => 'Amara Wilson',
                'service' => 'Box Braids',
                'rating' => 5,
                'comment' => 'Best braider in town! My box braids lasted for months and looked fresh the entire time. Professional service and great atmosphere.',
                'date' => '2024-01-10'
            ],
            [
                'id' => 3,
                'name' => 'Jennifer Brown',
                'service' => 'Wig Installation',
                'rating' => 5,
                'comment' => 'Precious is so skilled! My wig looks completely natural. She took her time to make sure everything was perfect. Will definitely be back!',
                'date' => '2024-01-05'
            ]
        ];

        return response()->json([
            'success' => true,
            'testimonials' => $testimonials
        ]);
    }

    /**
     * Get FAQ data.
     */
    public function getFAQ()
    {
        $faqs = [
            [
                'id' => 1,
                'question' => 'How long do the braids last?',
                'answer' => 'Depending on the style and maintenance, braids typically last 6-8 weeks. We provide aftercare instructions to help extend the life of your braids.'
            ],
            [
                'id' => 2,
                'question' => 'Do you provide hair or do I need to bring my own?',
                'answer' => 'We can provide high-quality hair for an additional cost, or you can bring your own. We\'ll let you know the hair requirements when you book.'
            ],
            [
                'id' => 3,
                'question' => 'How far in advance should I book?',
                'answer' => 'We recommend booking at least 1-2 weeks in advance, especially for weekends and popular styles. However, we sometimes have same-day availability.'
            ],
            [
                'id' => 4,
                'question' => 'What is your cancellation policy?',
                'answer' => 'We require at least 24 hours notice for cancellations. Same-day cancellations may incur a fee. We understand emergencies happen, so please contact us to discuss.'
            ],
            [
                'id' => 5,
                'question' => 'Do you offer touch-up services?',
                'answer' => 'Yes! We offer touch-up services for styles done at our salon within 2 weeks of the original appointment at a reduced rate.'
            ]
        ];

        return response()->json([
            'success' => true,
            'faqs' => $faqs
        ]);
    }

    /**
     * Get contact information.
     */
    public function getContactInfo()
    {
        $contact = [
            'business_name' => "Dab's Beauty Touch",
            'tagline' => 'Revamping Confidence Through Style Since 2015',
            'phone' => '+44 7123 456789',
            'email' => 'info@dabsbeautytouch.com',
            'whatsapp' => '+44 7123 456789',
            'address' => 'London, United Kingdom',
            'hours' => [
                'monday' => '9:00 AM - 6:00 PM',
                'tuesday' => '9:00 AM - 6:00 PM',
                'wednesday' => '9:00 AM - 6:00 PM',
                'thursday' => '9:00 AM - 6:00 PM',
                'friday' => '9:00 AM - 6:00 PM',
                'saturday' => '8:00 AM - 5:00 PM',
                'sunday' => 'Closed'
            ],
            'social_media' => [
                'instagram' => '@dabsbeautytouch',
                'facebook' => 'DabsBeautyTouch',
                'tiktok' => '@dabsbeautytouch'
            ]
        ];

        return response()->json([
            'success' => true,
            'contact' => $contact
        ]);
    }
}
