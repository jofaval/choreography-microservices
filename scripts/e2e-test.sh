cd ./src/

cd ./ship_orders/
sh ./scripts/e2e-test.sh
cd ..

cd ./stocks/
sh ./scripts/e2e-test.sh
cd ..

cd ./payments/
sh ./scripts/e2e-test.sh
cd ..

cd ./shipments/
sh ./scripts/e2e-test.sh
cd ..

cd ./invoices/
sh ./scripts/e2e-test.sh
cd ..

cd ./notifications/
sh ./scripts/e2e-test.sh
cd ..

cd ..