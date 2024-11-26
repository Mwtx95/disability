import { PrismaClient, Status, VendorStatus } from '@prisma/client';

const prisma = new PrismaClient();

async function main() {
  // Create Categories
  const mobilityCategory = await prisma.category.create({
    data: {
      name: 'Mobility Equipment',
      description: 'Equipment to assist with mobility and movement',
    },
  });

  const communicationCategory = await prisma.category.create({
    data: {
      name: 'Communication Devices',
      description: 'Devices to assist with communication and speech',
    },
  });

  const hearingCategory = await prisma.category.create({
    data: {
      name: 'Hearing Aids',
      description: 'Equipment to assist with hearing impairments',
    },
  });

  // Create Locations
  const mainClinic = await prisma.location.create({
    data: {
      name: 'Main Disability Clinic',
      type: 'Clinic',
      description: 'Primary disability support clinic',
    },
  });

  const rehabCenter = await prisma.location.create({
    data: {
      name: 'Rehabilitation Center',
      type: 'Center',
      description: 'Rehabilitation and therapy center',
    },
  });

  // Create Vendors
  const mobilityVendor = await prisma.vendor.create({
    data: {
      name: 'MobilityPlus Solutions',
      contactPerson: 'John Smith',
      email: 'john@mobilityplus.com',
      phoneNumber: '555-0123',
      description: 'Leading supplier of mobility equipment',
      status: VendorStatus.ACTIVE,
    },
  });

  const medicalVendor = await prisma.vendor.create({
    data: {
      name: 'MedTech Supplies',
      contactPerson: 'Sarah Johnson',
      email: 'sarah@medtech.com',
      phoneNumber: '555-0124',
      description: 'Medical equipment supplier',
      status: VendorStatus.ACTIVE,
    },
  });

  // Create Assets and Asset Items
  const wheelchair = await prisma.asset.create({
    data: {
      name: 'Electric Wheelchair',
      description: 'Power wheelchair with adjustable settings',
      categoryId: mobilityCategory.id,
      locationId: mainClinic.id,
    },
  });

  await prisma.assetItem.create({
    data: {
      assetId: wheelchair.id,
      serialNumber: 'WC2023001',
      purchaseDate: new Date('2023-01-15'),
      warrantyExpiryDate: new Date('2025-01-15'),
      notes: 'Premium model with extended battery life',
      quantity: 5,
      price: 2500.00,
      status: Status.AVAILABLE,
      locationId: mainClinic.id,
      vendorId: mobilityVendor.id,
    },
  });

  const hearingAid = await prisma.asset.create({
    data: {
      name: 'Digital Hearing Aid',
      description: 'Advanced digital hearing aid with noise cancellation',
      categoryId: hearingCategory.id,
      locationId: rehabCenter.id,
    },
  });

  await prisma.assetItem.create({
    data: {
      assetId: hearingAid.id,
      serialNumber: 'HA2023001',
      purchaseDate: new Date('2023-02-20'),
      warrantyExpiryDate: new Date('2024-02-20'),
      notes: 'Rechargeable model with Bluetooth connectivity',
      quantity: 10,
      price: 1200.00,
      status: Status.AVAILABLE,
      locationId: rehabCenter.id,
      vendorId: medicalVendor.id,
    },
  });

  const communicationDevice = await prisma.asset.create({
    data: {
      name: 'Speech Generation Device',
      description: 'Portable communication aid with touch screen',
      categoryId: communicationCategory.id,
      locationId: mainClinic.id,
    },
  });

  await prisma.assetItem.create({
    data: {
      assetId: communicationDevice.id,
      serialNumber: 'SGD2023001',
      purchaseDate: new Date('2023-03-10'),
      warrantyExpiryDate: new Date('2024-03-10'),
      notes: 'Multi-language support with customizable interface',
      quantity: 3,
      price: 1800.00,
      status: Status.AVAILABLE,
      locationId: mainClinic.id,
      vendorId: medicalVendor.id,
    },
  });

  // Additional Assets and Asset Items
  const manualWheelchair = await prisma.asset.create({
    data: {
      name: 'Manual Wheelchair',
      description: 'Lightweight folding manual wheelchair',
      categoryId: mobilityCategory.id,
      locationId: rehabCenter.id,
    },
  });

  await prisma.assetItem.create({
    data: {
      assetId: manualWheelchair.id,
      serialNumber: 'MWC2023001',
      purchaseDate: new Date('2023-04-15'),
      warrantyExpiryDate: new Date('2025-04-15'),
      notes: 'Adjustable armrests and footrests',
      quantity: 8,
      price: 800.00,
      status: Status.AVAILABLE,
      locationId: rehabCenter.id,
      vendorId: mobilityVendor.id,
    },
  });

  const walkingCane = await prisma.asset.create({
    data: {
      name: 'Smart Walking Cane',
      description: 'Walking cane with LED light and fall detection',
      categoryId: mobilityCategory.id,
      locationId: mainClinic.id,
    },
  });

  await prisma.assetItem.create({
    data: {
      assetId: walkingCane.id,
      serialNumber: 'SWC2023001',
      purchaseDate: new Date('2023-05-20'),
      warrantyExpiryDate: new Date('2024-05-20'),
      notes: 'Built-in GPS tracking and emergency alert system',
      quantity: 15,
      price: 250.00,
      status: Status.AVAILABLE,
      locationId: mainClinic.id,
      vendorId: mobilityVendor.id,
    },
  });

  const brailleDisplay = await prisma.asset.create({
    data: {
      name: 'Refreshable Braille Display',
      description: '40-cell refreshable braille display with USB-C',
      categoryId: communicationCategory.id,
      locationId: mainClinic.id,
    },
  });

  await prisma.assetItem.create({
    data: {
      assetId: brailleDisplay.id,
      serialNumber: 'BD2023001',
      purchaseDate: new Date('2023-06-10'),
      warrantyExpiryDate: new Date('2025-06-10'),
      notes: 'Compatible with screen readers and mobile devices',
      quantity: 4,
      price: 2800.00,
      status: Status.AVAILABLE,
      locationId: mainClinic.id,
      vendorId: medicalVendor.id,
    },
  });

  const prostheticLeg = await prisma.asset.create({
    data: {
      name: 'Advanced Prosthetic Leg',
      description: 'Microprocessor-controlled prosthetic knee joint',
      categoryId: mobilityCategory.id,
      locationId: rehabCenter.id,
    },
  });

  await prisma.assetItem.create({
    data: {
      assetId: prostheticLeg.id,
      serialNumber: 'PL2023001',
      purchaseDate: new Date('2023-07-01'),
      warrantyExpiryDate: new Date('2025-07-01'),
      notes: 'Adaptive stance and swing phase control',
      quantity: 3,
      price: 45000.00,
      status: Status.AVAILABLE,
      locationId: rehabCenter.id,
      vendorId: medicalVendor.id,
    },
  });

  const eyeTracker = await prisma.asset.create({
    data: {
      name: 'Eye Tracking Device',
      description: 'Precision eye tracking system for computer control',
      categoryId: communicationCategory.id,
      locationId: mainClinic.id,
    },
  });

  await prisma.assetItem.create({
    data: {
      assetId: eyeTracker.id,
      serialNumber: 'ET2023001',
      purchaseDate: new Date('2023-08-15'),
      warrantyExpiryDate: new Date('2024-08-15'),
      notes: 'High-precision tracking with calibration-free operation',
      quantity: 5,
      price: 1600.00,
      status: Status.AVAILABLE,
      locationId: mainClinic.id,
      vendorId: medicalVendor.id,
    },
  });

  const hearingImplant = await prisma.asset.create({
    data: {
      name: 'Cochlear Implant System',
      description: 'Complete cochlear implant system with external processor',
      categoryId: hearingCategory.id,
      locationId: mainClinic.id,
    },
  });

  await prisma.assetItem.create({
    data: {
      assetId: hearingImplant.id,
      serialNumber: 'CI2023001',
      purchaseDate: new Date('2023-09-01'),
      warrantyExpiryDate: new Date('2026-09-01'),
      notes: 'Advanced sound processing with wireless connectivity',
      quantity: 2,
      price: 25000.00,
      status: Status.AVAILABLE,
      locationId: mainClinic.id,
      vendorId: medicalVendor.id,
    },
  });
}

main()
  .then(async () => {
    await prisma.$disconnect();
  })
  .catch(async e => {
    console.error(e);
    await prisma.$disconnect();
    process.exit(1);
  });
