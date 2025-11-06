#!/bin/bash

# Test PDF Export - Quick Verification Script
# This script helps verify the PDF export functionality

echo "=========================================="
echo "PDF Export Test Script"
echo "=========================================="
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if Laravel is installed
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: artisan file not found. Are you in the Laravel project root?${NC}"
    exit 1
fi

echo -e "${YELLOW}Step 1: Checking Spatie Laravel PDF installation...${NC}"
if composer show spatie/laravel-pdf &> /dev/null; then
    echo -e "${GREEN}✓ Spatie Laravel PDF is installed${NC}"
else
    echo -e "${RED}✗ Spatie Laravel PDF is NOT installed${NC}"
    echo "Run: composer require spatie/laravel-pdf"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 2: Checking database connection...${NC}"
if php artisan db:show &> /dev/null; then
    echo -e "${GREEN}✓ Database connection is working${NC}"
else
    echo -e "${RED}✗ Database connection failed${NC}"
    echo "Check your .env file database settings"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 3: Checking if users exist...${NC}"
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -n 1)
if [ "$USER_COUNT" -gt 0 ]; then
    echo -e "${GREEN}✓ Found $USER_COUNT user(s) in database${NC}"
else
    echo -e "${RED}✗ No users found${NC}"
    echo "Run: php artisan db:seed --class=InvoiceWithItemsSeeder"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 4: Checking if invoices exist...${NC}"
INVOICE_COUNT=$(php artisan tinker --execute="echo App\Models\Invoice::count();" 2>/dev/null | tail -n 1)
if [ "$INVOICE_COUNT" -gt 0 ]; then
    echo -e "${GREEN}✓ Found $INVOICE_COUNT invoice(s) in database${NC}"
else
    echo -e "${RED}✗ No invoices found${NC}"
    echo "Run: php artisan db:seed --class=InvoiceWithItemsSeeder"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 5: Checking routes...${NC}"
if php artisan route:list | grep -q "invoices.export.pdf"; then
    echo -e "${GREEN}✓ PDF export route is registered${NC}"
else
    echo -e "${RED}✗ PDF export route NOT found${NC}"
    echo "Check routes/web.php"
    exit 1
fi

echo ""
echo -e "${YELLOW}Step 6: Checking PDF template...${NC}"
if [ -f "resources/views/pdf/invoices/template_1.blade.php" ]; then
    echo -e "${GREEN}✓ PDF template exists${NC}"
else
    echo -e "${RED}✗ PDF template NOT found${NC}"
    echo "Template should be at: resources/views/pdf/invoices/template_1.blade.php"
    exit 1
fi

echo ""
echo "=========================================="
echo -e "${GREEN}All checks passed! ✓${NC}"
echo "=========================================="
echo ""
echo "Login Credentials:"
echo "  Email: admin@example.com"
echo "  Password: password"
echo ""
echo "Test URLs:"
echo "  Login: http://localhost:8000/login"
echo "  Invoices: http://localhost:8000/invoices"
echo ""
echo "To start the server:"
echo "  Terminal 1: npm run dev"
echo "  Terminal 2: php artisan serve"
echo ""
echo "Then navigate to http://localhost:8000 and test the PDF export!"
echo ""
